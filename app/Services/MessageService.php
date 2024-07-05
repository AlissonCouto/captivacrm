<?php

namespace App\Services;

use Twilio\Rest\Client;

class MessageService{

   public function twillioSendMessage($message, $client_phone){
        $sid    = config('twillio.account_sid');
        $token  = config('twillio.auth_token');
        $phone_number = config('twillio.phone_number');
            
        $twilio = new Client($sid, $token);
    
       $message = $twilio->messages
        ->create("whatsapp:+55" . $client_phone, // to
            array(
                "from" => "whatsapp:" . $phone_number,
                "body" => $message
            )
        );
    
        return $message;
    } // twillioSendMessage()

}