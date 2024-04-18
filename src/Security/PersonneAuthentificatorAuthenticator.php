<?php

namespace App\Security;

use App\Entity\Administrateur;
use App\Entity\Client;
use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Symfony\Component\BrowserKit\Response as BrowserKitResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

class PersonneAuthentificatorAuthenticator extends AbstractAuthenticator
{
    private $personneRepository;
    private $urlGenerator;
    private $session;



    public function __construct(PersonneRepository $personneRepository, UrlGeneratorInterface $urlGenerator, SessionInterface $session)
    {
        $this->personneRepository = $personneRepository;
        $this->urlGenerator = $urlGenerator;
        $this->session = $session;


    }
    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'app_login' && $request->isMethod('POST');
    }
    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('_email', '');
    
        var_dump($email); // Vérifiez la valeur de l'email
    
        $personne = $this->personneRepository->findOneBy(['mail_personne' => $email]);
    
        var_dump($personne); // Vérifiez si l'utilisateur est correctement récupéré
    
        if (!$personne) {
            throw new CustomUserMessageAuthenticationException('Email non trouvé.');
        }
    
        // Vérification du mot de passe
        $password = $request->request->get('_password', '');
        var_dump($password); // Vérifiez la valeur du mot de passe
    
        if (!password_verify($password, $personne->getMdpPersonne())) {
            throw new CustomUserMessageAuthenticationException('Mot de passe incorrect.');
        }
    
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($password)
        );
    }
    

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $personne = $token->getUser(); // Obtenez l'objet Personne de l'utilisateur authentifié
        $this->session->set('personne', $personne);

    
        // Accédez aux informations spécifiques à l'administrateur ou au client
        if ($personne instanceof Administrateur) {
            $role = $personne->getRole();
            $this->session->set('role', $role);

            // Accédez aux autres informations de la personne, par exemple $personne->getPrenomPersonne(), etc.
        } elseif ($personne instanceof Client) {
            $age = $personne->getAge();
            $genre = $personne->getGenre();
            $this->session->set('age', $age);
            $this->session->set('genre', $genre);
            // Accédez aux autres informations de la personne, par exemple $personne->getPrenomPersonne(), etc.
        }
    
        // Rediriger l'utilisateur vers une page spécifique après la connexion
        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
            // Récupérer les informations de l'exception pour afficher un message d'erreur
            $errorMessage = $exception->getMessage();
        
            // Ajouter un message flash pour afficher l'erreur à l'utilisateur sur la page de connexion
            $this->$this->addFlash('error', $errorMessage);
        
            // Rediriger l'utilisateur vers la page de connexion
            return new RedirectResponse($this->urlGenerator->generate('app_signIn'));
        
    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}
