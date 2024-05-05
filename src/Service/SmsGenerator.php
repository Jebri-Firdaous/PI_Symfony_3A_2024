<?php
// src/Service/MessageGenerator.php
namespace App\Service;

use Twilio\Rest\Client;

class SmsGenerator
{
    
    public function SendSms(string $number, string $name, string $text)
    {
        
        $accountSid = "ACb7699b0b6314abd7941be7a60f5822b5";  //Identifiant du compte twilio
        $authToken = "f3c626e09affc552fadfe4aa4977896c"; //Token d'authentification
        $fromNumber = "+19784867818"; // Numéro de test d'envoie sms offert par twilio

        $toNumber = $number; // Le numéro de la personne qui reçoit le message
        $message = 'Dr '.$name .' '.$text.''; //Contruction du sms

        //Client Twilio pour la création et l'envoie du sms
        $client = new Client($accountSid, $authToken);

        $client->messages->create(
            $toNumber,
            [
                'from' => $fromNumber,
                'body' => $message,
            ]
        );


    }
}