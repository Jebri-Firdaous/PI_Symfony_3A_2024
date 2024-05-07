<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Hotel;
use App\Entity\Reservation;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PaiementController extends AbstractController
{
    #[Route('/paiement/{id}', name: 'app_paiement')]
    public function index(Hotel $hotel): Response
    {dump($hotel);
        // Vous pouvez également ajouter ici la logique pour récupérer les informations sur la réservation

        return $this->render('Front/paiement/Pindex.html.twig', [
            'controller_name' => 'PaiementController',
            'hotel' => $hotel,
        ]);
    }

    #[Route('/checkout/{id}', name: 'app_checkout')]
    public function checkout($id, EntityManagerInterface $em): Response
    {
        Stripe::setApiKey('sk_test_51PBganFyJAzlzpUw4JmgMTG6UKyiLPEwdkcCrSuF5qMEJqMEUfqhAVlkDi5rojpIY1L74ChLU3Vfja8h1FfAwZcY00rh50kX3K');

        $hotel = $em->getRepository(Hotel::class)->find($id);

        // Vous pouvez ajouter ici la logique pour créer une réservation et enregistrer dans la base de données

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data' => [
                        'currency'     => 'USD',
                        'product_data' => [
                            'name' => 'Montant :', // Modifier le nom en fonction de vos besoins
                        ],
                        'unit_amount'  => $hotel->getPrix1() * 100, // Utilisez le prix de la nuit de l'hôtel pour le montant
                        'unit_amount'  => $hotel->getPrix2() * 100,
                        'unit_amount'  => $hotel->getPrix3() * 100,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($session->url, 303);
    }

    #[Route('/success-url', name: 'success_url')]
    public function successUrl(SessionInterface $session1, EntityManagerInterface $entityManager): Response
    {
        return $this->render('Front/paiement/success.html.twig', []);
    }

    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('Front/paiement/cancel.html.twig', []);
    }
}