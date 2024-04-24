<?php

namespace App\Controller;
use Twilio\Rest\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class SmsController extends AbstractController
{
    #[Route('/sms' ,name: 'send_sms')]
     
    public function sendSms(Request $request): Response
    {
        $sid = "AC9b81b4f943aab8c49b38b51f886332a2";
        $token = "9ed26881aff98928a257c3ded57af827";
        $destination = $request->query->get('destination');
    $dateDepart = $request->query->get('dateDepart');
    $prix = $request->query->get('prix');
    $duree = $request->query->get('duree');

     

        $messageContent = "Bonjour, nous vous confirmons la réservation de votre billet :\nDestination: $destination\nDate de départ: $dateDepart\nPrix: $prix\nDurée: $duree";

        $client = new Client($sid, $token);
    
        $message = $client->messages->create(
            "+21692701943", // Destinataire
            [
                "from" => "+15178887499", // Votre numéro Twilio
                "body" => $messageContent
            ]
        );
    
        return new Response('SMS sent with Twilio! SID: ' . $message->sid);
}

}