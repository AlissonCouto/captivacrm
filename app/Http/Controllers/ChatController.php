<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Services\ChatService;
use Illuminate\Support\Facades\Redis;
use App\Jobs\TotalChatNotifications;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    private $service;

    public function __construct(ChatService $service){
        $this->service = $service;
    }

    public function index(Request $request, Lead $lead){

        $messages = $lead->messages()->orderby('created_at', 'ASC')->get();

        /* Marcando todas as mensagens do chat como lido */
        $lead->messages()->where([
            ['from', '=', 'lead'],
            ['status', '<>', 'read']
        ])->update(['status' => 'read']);

        TotalChatNotifications::dispatch($lead->companyId);
        /* Marcando todas as mensagens do chat como lido */
        
        return view('admin.chat.index')->with(compact('messages', 'lead'));

    } // index()

    public function store(Request $request, Lead $lead){

        $message = $request->get('message') ?? null;

        if($message){

            $return = $this->service->store($request, $lead);

            echo json_encode($return);
            die;
        }

    } // store()

    public function totalStatus(Request $request){

        $user = Auth::user();
        $company = $user->company()->first();
        $return = $this->service->totalStatus($company->id);

        return json_encode($return);

    } // totalStatus()
}
