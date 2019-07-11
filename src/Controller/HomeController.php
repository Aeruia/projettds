<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;

Class HomeController extends AbstractController
{   
   

    /**
     * @Route("/", name="home") 
     * @param ProductRepository $repository 
     * @return Response
     */

    public function index(): Response
    {   
        
        return $this->render('pages/homepage.html.twig', [
            'current_menu' => 'home',
          
            ]);
    }
  

}