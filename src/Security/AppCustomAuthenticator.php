<?php


namespace App\Security;




use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Symfony\Component\Security\Core\Security;

use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;

use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;

use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

use Symfony\Component\Security\Http\Util\TargetPathTrait;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;




class AppCustomAuthenticator extends AbstractLoginFormAuthenticator

{

    use TargetPathTrait;




    public const LOGIN_ROUTE = 'app_login';

    private const MAX_LOGIN_ATTEMPTS = 5;

    private const LOGIN_ATTEMPTS_SESSION_KEY = 'login_attempts';

    private const FORM_BLOCKED_SESSION_KEY = 'form_blocked_until';

    private EntityManagerInterface $entityManager;






    public $authorizationChecker;






    public function __construct(private UrlGeneratorInterface $urlGenerator, AuthorizationCheckerInterface $authorizationChecker,   EntityManagerInterface $entityManager)

    

    {

        $this->authorizationChecker = $authorizationChecker;

       // Injection de l'EntityManager

       $this->entityManager = $entityManager;

       $this->authorizationChecker = $authorizationChecker;






    }




    public function authenticate(Request $request): Passport

    {

        $email = $request->request->get('email', '');




        $request->getSession()->set(Security::LAST_USERNAME, $email);




        return new Passport(

            new UserBadge($email),

            new PasswordCredentials($request->request->get('password', '')),

            [

                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),            ]

        );

    }




    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response

    {

        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {

            return new RedirectResponse($targetPath);

        }

        $userRoles = $token->getUser()->getRoles();

        if ($userRoles) {

            $firstRole = $userRoles[0];

            if($firstRole === 'CLIENT')

            return new RedirectResponse($this->urlGenerator->generate('app_acceuil'));




            return new RedirectResponse($this->urlGenerator->generate('app_back_acceuil'));

        }

       




        

        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);

    }




    protected function getLoginUrl(Request $request): string

    {

        return $this->urlGenerator->generate(self::LOGIN_ROUTE);

    }

    public function onAuthenticationFailure(Request $request, \Symfony\Component\Security\Core\Exception\AuthenticationException $exception): Response

{

    // Increment login attempts on failure

    $loginAttempts = $request->getSession()->get(self::LOGIN_ATTEMPTS_SESSION_KEY, 0) + 1;

    $request->getSession()->set(self::LOGIN_ATTEMPTS_SESSION_KEY, $loginAttempts);




    // Check if the form is currently blocked

    $formBlockedUntil = $request->getSession()->get(self::FORM_BLOCKED_SESSION_KEY);

    if ($formBlockedUntil instanceof \DateTime && $formBlockedUntil > new \DateTime()) {

        // The form is still blocked, return a response indicating that

        return new Response('Votre formulaire est actuellement bloqué. Veuillez réessayer plus tard.');

    }




    if ($loginAttempts >= self::MAX_LOGIN_ATTEMPTS) {

        // Reset login attempts to zero

        $request->getSession()->set(self::LOGIN_ATTEMPTS_SESSION_KEY, 0);




        // Set the user as banned

        $userRepository = $this->entityManager->getRepository(User::class);

        $user = $userRepository->findOneBy(['email' => $request->request->get('email')]);

        

        if ($user) {

            $user->setIsBanned(true); // Assuming setIsBanned() is the setter method for isBanned

            $this->entityManager->flush();

        }




        // Set the form as blocked for 2 minutes

        $blockedUntil = new \DateTime();

        $blockedUntil->add(new \DateInterval('PT10S'));

        $request->getSession()->set(self::FORM_BLOCKED_SESSION_KEY, $blockedUntil);




        // Add flash message for maximum login attempts reached

        $request->getSession()->getFlashBag()->add('error', 'Vous avez été banni pendant 2 minutes en raison de tentatives de connexion infructueuses.');

    } elseif ($loginAttempts === 3) {

        // Add flash message for reaching 3 attempts

        $request->getSession()->getFlashBag()->add('error', 'Tentative de connexion échouée. Vous avez encore deux tentatives.');

    }




    // Continue with the default behavior of the parent onAuthenticationFailure method

    return parent::onAuthenticationFailure($request, $exception);

}




}




