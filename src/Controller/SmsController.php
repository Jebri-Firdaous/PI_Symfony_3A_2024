<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twilio\Rest\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SmsController extends AbstractController
{
    #[Route('/sms', name: 'app_sms')]
    public function sendSms(): Response
    {
       $sid="ACd712af928ef38f3b4753d770276588a4";
         $token = "#";
        $phone = "92701943";
$firstname="ons";
        $client = new Client($sid,$token);

        $message = $client->messages->create(
            "+216".$phone, // to
            array(
                "from" => "+12514514104", //modified 
                "body" => "Hello" .$firstname.
                " ".
                "We're excited to let you know that your recent order has been shipped! Your package is on its way and should be arriving soon."
            )
        );
        return $this->render('home/backhome.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
}

}