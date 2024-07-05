<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Lead;
use App\Models\Message;
use App\Models\Company;

use App\Services\MessageService;

class ChatService{

    private $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;    
    }

    public function store(Request $data, Lead $lead){

        try{

            $message = $data->get('message');
            $user = Auth::user();
            $company = $user->company()->first();
            $client_phone = str_replace(['(', ')', ' ', '-'], ['', '', '', ''], $lead->phone);

            /* Salvando mensagem no banco de dados */
            /* Após ativar disparo da twillio aqui -> Pegar dados do objeto da twillio */
            // $message = $this->messageService->twillioSendMessage($message, $client_phone);
            $new_message = new Message();
            $new_message->sid = 'sid-de-teste-' . strtotime(now());//$message->sid;
            $new_message->status = 'delivered';//$message->status;
            $new_message->message = $message;//$message->body;
            $new_message->phone = $client_phone;
            $new_message->from = 'company';
            $new_message->leadId = $lead->id;
            $new_message->companyId = $company->id;

            $new_message->save();
            
            $html = view('admin.chat.line')->with(['message' => $new_message])->render();

            return [
                'success' => true,
                'message' => 'Mensagem enviada com sucesso!',
                'data' => $html
            ];

        }catch(\Exception $e){
            return [
                'success' => false,
                //'message' => $e->getMessage(),
                'message' => 'Erro ao enviar mensagem!'
            ];
        }

    } // store()

    public function totalStatus($companyId){
        
        $company = Company::find($companyId);

        $total = $company->messages()->where([
            ['companyId', '=', $company->id],
            ['status', '<>', 'read'],
            ['from', '=', 'lead']
        ])->count();

        return [
            'total' => $total
        ];

    } // totalStatus()

}