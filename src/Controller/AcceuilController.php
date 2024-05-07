<?php

namespace App\Controller;
use App\Controller\ReservationController;
use Psr\Container\ContainerInterface;
use App\Entity\Billet;
use App\Entity\Station;
use App\Form\BilletType;
use App\Form\StationType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use App\Repository\billetRepository;
 use Knp\Component\Pager\PaginatorInterface;
 use App\Repository\StationRepository;
use App\Repository\HotelRepository;


use App\Entity\Hotel;
use App\Form\HotelType;
use Doctrine\ORM\EntityManagerInterface;
class AcceuilController extends AbstractController
{
    #[Route('/home', name: 'app_acceuil')]
    public function index(ContainerInterface $container): Response
    {
        // Starting or resuming a session
        session_start();
        // $_SESSION['user'] = $c->find(48);

        // Adding a variable to the session
        $_SESSION['user_id'] = 65;

        return $this->render('Front/index.html.twig', [
            'controller_name' => 'AcceuilController',
            'container' => $container,
        ]);
    }

    #[Route('/profile', name: 'app_profile')]
    public function profile(ContainerInterface $container): Response
    {
        return $this->render('user/profile.html.twig', [
            'controller_name' => 'AcceuilController',
            'container' => $container,
        ]);
    }

    #[Route('/transport', name: 'app_transport')]
    public function show(Request $req,ManagerRegistry $Manager,billetRepository $repo,UserRepository $us,PaginatorInterface $paginator ): Response
    {   
     
        $list=$repo->findAll();
        dump($list);
            $list = $repo->findAll();
            $list = $paginator->paginate(
                $list, /* query NOT result */
                $req->query->getInt('page', 1),
                3
            );
        return $this->render('Front/transport.html.twig', [
           
            'list' => $list
        ]);
    }
    #[Route('/transport/{id}', name: 'app_reserver',methods:['GET','POST'])]
    public function reserver(Request $req,ManagerRegistry $Manager,billetRepository $repo,UserRepository $us,PaginatorInterface $paginator,$id ): Response
    {   
        $bill=$repo->find($id);
        $bill->setIdPersonne($us->find(65));

        $em=$Manager->getManager();
        $em->persist($bill);
        $em->flush();

        return $this->redirectToRoute('app_transport');

    }
    #[Route('/parking', name: 'app_parking')]
    public function parkingHome(): Response
    {
        return $this->render('Front/parking.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/sante', name: 'app_sante')]
    public function santeHome(): Response
    {
        return $this->render('Front/sante.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/shopping', name: 'app_shopping')]
    public function shoppingHome(): Response
    {
        return $this->render('Front/shopping.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/tourism', name: 'app_tourisme')]
    public function tourismHome(): Response
    {
        return $this->render('Front/tourism.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    #[Route('/contact', name: 'app_contact')]
    public function contactHome(): Response
    {
        return $this->render('Front/contact.html.twig', [
           
            // 'list' => $list
        ]);
    }
    #[Route('/listebilletsreserves', name: 'liste_billets_reserves')]
    public function listebilletsreserves(): Response
    {
        return $this->render('home/listebilletreserves.html.twig', [
            'controller_name' => 'AcceuilController',
        ]);
    }
    
    #[Route('/help', name: 'app_help_center')]

    public function help(ContainerInterface $container): Response
    {
        return $this->render('Front/helpcenter.html.twig', [
            'controller_name' => 'AcceuilController',
            'container' => $container,
        ]);
    }
 
}
