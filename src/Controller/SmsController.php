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
      

        $sid = "AC20860627b7ea9659eea11b1a6bd3c231";
        $token = "eefae6ca2a5474833cf907fc1cf3a1b1";
        $destination = $request->query->get('destination');
    $dateDepart = $request->query->get('dateDepart');
    $prix = $request->query->get('prix');
    $duree = $request->query->get('duree');

        $messageContent = "Bonjour, nous vous confirmons la réservation de votre billet :\nDestination: $destination\nDate de départ: $dateDepart\nPrix: $prix\nDurée: $duree";

        $client = new Client($sid, $token);
    
        $message = $client->messages->create(
            "+21692701943", // Destinataire
            [
                "from" => "+18507538714", // Votre numéro Twilio
                "body" => $messageContent
            ]
        );
    
        // return new Response('SMS sent with Twilio! SID: ' . $message->sid);
        return $this->redirectToRoute('app_transport');

}

}