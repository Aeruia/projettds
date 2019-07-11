<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{
    /**
     * @Route ("/login", name="login")
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // $user = new User();
        // $user->setUsername('bob')
        //     ->setPassword('bob')
        //     ->setRole(1);
        // $em = $this->getDoctrine()->getManager();
        // $em ->persist($user);
        // $em ->flush();

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'Last_username' => $lastUsername,
            'error' => $error,
        ]);
        
    }

    

}