<?php

namespace App\Controller;



use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;

use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

/**
 * @Route("/user")
 */
class AdminUserController extends AbstractController
{
    /**
     * @Route("/", name="user.index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
    

    

    /**
     * @Route("/edit/{id}", name="user.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'user modifié avec succès ');

            return $this->redirectToRoute('user.index', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}", name="user.delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            
            $em = $this->getDoctrine()->getManager();
            try {
                $em->remove($user);
                $em->flush();
            
                $this->addFlash('success', 'user removed');
                return $this->redirectToRoute('user.index');
            } catch (ForeignKeyConstraintViolationException $em) {
               
               
           
                $this->addFlash('danger', 'Impossible, user est associé à un produit ');
                return  $this->redirectToRoute('admin.user.index');
                
            } 
        

        }
       
       
        
    }
}
