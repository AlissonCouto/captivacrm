<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Lead;
use App\Models\Message;
use App\Services\MessageService;
use App\Jobs\ReceiveMessage;
use App\Jobs\TotalChatNotifications;
use App\Jobs\LeadMessageReadJob;

class MessageController extends Controller
{

    private $promptSite;
    private $promptNoSite;
    private $model;
    private $service;

    public function __construct(MessageService $service){

        $this->model = 'gpt-3.5-turbo';

        $this->promptSite = 'Você é um assistente virtual especializado em marketing digital e está ajudando a criar mensagens curtas e diretas para vender serviços de reformulação de sites para empresas. As informações sobre a empresa incluem o nome da empresa, o tipo de negócio, a localização e se a empresa já possui um site ou não.
        Informações da Empresa:
        
        Nome da Empresa: Orto Seu Zé
        Tipo de Negócio: Dentista (por exemplo, dentista, restaurante, loja de roupas, etc.)
        Localização: Naviraí/MS (Cidade/Estado)
        Possui Site: Sim
        Objetivo:
        
        Se a empresa possui site: Ofereça os serviços de reformulação do site, destacando brevemente os benefícios de ter um site moderno e otimizado e solicitando falar com o responsável pela decisão de compra.
        Formate a resposta de modo que fique bom no Whatsapp';

        $this->promptNoSite = 'Você é um assistente virtual especializado em marketing digital e está ajudando a criar mensagens curtas e diretas para vender serviços de criação de sites para empresas. As informações sobre a empresa incluem o nome da empresa, o tipo de negócio, a localização e se a empresa já possui um site ou não.

        Informações da Empresa:
        
        Nome da Empresa: Orto Seu Zé
        Tipo de Negócio: Dentista (por exemplo, dentista, restaurante, loja de roupas, etc.)
        Localização: Naviraí/MS (Cidade/Estado)
        Possui Site: Não
        Objetivo:
        
        Se a empresa não possui site: Ofereça os serviços de criação de um site profissional, destacando brevemente a importância de ter uma presença online e solicitando falar com o responsável pela decisão de compra.
        
        Formate a resposta de modo que fique bom no Whatsapp';

        $this->service = $service;
    }

    public function gptMessageFormulation(){
        
        return OpenAI::completions()->create([
            'model' => $this->model,
            'prompt' => $this->promptNoSite,
            'max_tokens' => 2000 
        ])->choices[0]->text;

    } // gptMessageFormulation()

    /* Dispara Mensagens via Whatsapp */
    public function sendMessages(){

        $user = Auth::user();
        $company = $user->company()->first();
        $setting = $company->setting()->first();
        $message = '';

        $leads = Lead::where([
            ['id', '=', 13]
        ])->get();

        if($leads){
            foreach($leads as $lead){

                if($lead->phone){
                    // Personalizando mensagem no chat gpt
                    if($setting->messageType == 'chatgpt'){
                        $gpt = $this->gptMessageFormulation();
                    }else{
                        $message = $setting->messageDefault;
                    }
        
                    $client_phone = str_replace(['(', ')', ' ', '-'], ['', '', '', ''], $lead->phone);
                    
                    try{

                        // Disparando mensagem para o cliente
                        $message = $this->service->twillioSendMessage($message, $client_phone);
                        
                        /* Salvando mensagem no banco de dados */
                        $new_message = new Message();
                        $new_message->sid = $message->sid;
                        $new_message->status = $message->status;
                        $new_message->message = $message->body;
                        $new_message->phone = $client_phone;
                        $new_message->from = 'company';
                        $new_message->leadId = $lead->id;
                        $new_message->companyId = $company->id;

                        $new_message->save();

                    }catch(\Exception $e){
                        dd($e->getMessage());
                    }

                }
    
            }
        }

    } // sendMessages()

    /* Mensagens recebidas dos clientes */
    public function receiveMessages(Request $request){

        try{
            
            $from = $request->get('From'); // Número de telefone do remetente
            $body = $request->get('Body'); // Conteúdo da mensagem

            // Remover o prefixo "whatsapp:" do número de telefone
            $from = str_replace('whatsapp:+55', '', $from);

            // Adicionar o dígito 9 adicional para buscar no banco de dados
            if (preg_match('/^(\d{2})(\d{8})$/', $from, $matches)) {
                $ddd = $matches[1];
                $number = $matches[2];
                $with_nine = $ddd . '9' . $number;
            }
            
            // Buscar o cliente no banco de dados pelo número de telefone com ou sem o dígito 9 adicional
            $lead = Lead::where('phone', $from)
                  ->orWhere('phone', $with_nine)
                  ->first();
                  
            if($lead){

                /* Salvando mensagem no banco de dados */
                $new_message = new Message();
                $new_message->sid = $request->get('MessageSid');
                $new_message->status = $request->get('SmsStatus');
                $new_message->message = $body;
                $new_message->phone = $from;
                $new_message->from = 'lead';
                $new_message->leadId = $lead->id;
                $new_message->companyId = $lead->companyId;

                $new_message->save();

                // Disparando evento do chat
                $companyId = $lead->companyId;
                $html = view('admin.chat.line')->with(['message' => $new_message])->render();

                // Adicionando mensagem ao chat
                ReceiveMessage::dispatch($body, $companyId, $html);
        
                // Atualizando notificação de chat
                TotalChatNotifications::dispatch($companyId);

            }

            

        }catch(\Exception $e){
            //dd($e->getMessage());
        }

       /* Log::driver('stderr')
        ->error('NEW MESSAGE');

        Log::driver('stderr')
        ->error(json_encode($request->all()));*/

    } // receiveMessages()

    /* Status das mensagens */
    public function statusMessages(Request $request){

        $message = Message::where([
            ['sid', '=', $request->get('MessageSid')]
        ])->first();

        if($message){

            // Buscando lead e atualizando campo se tem whatsapp
            $lead = Lead::where('id', $message->leadId)->first();

            if($lead && $request->get('MessageStatus') != 'failed'){
                $lead->whatsapp = 'yes';
                $lead->save();
            }

            $message->status = $request->get('MessageStatus');
            $message->save();

            $html = view('admin.chat.line')->with(compact('message'))->render();

            // sid, html, companyId
            LeadMessageReadJob::dispatch($message->sid, $html, $message->companyId);
        }

    } // statusMessages()

}