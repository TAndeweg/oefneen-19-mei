<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    #[Route(path: '/redirect', name: 'app_redirect')]
    public function redirectAction(Security $security): Response
    {
        if ($security->isGranted('ROLE_CUSTOMER')) {
            return $this->redirectToRoute('app_customer');
        }
        if ($security->isGranted('ROLE_EMPLOYEE')) {
            return $this->redirectToRoute('app_employee');
        }
        if ($security->isGranted('ROLE_OWNER')) {
            return $this->redirectToRoute('app_owner');
        }
        else {
            return $this->redirectToRoute('app_main');
        }
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
