<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CtController extends AbstractController
{
    /**
     * @Route("/home", name="ct_homepage")
     */
    public function index()
    {
        if(!empty($_SESSION['username']))
        {
            return $this->render('ct/index.html.twig', [
                'controller_name' => 'CtController',
            ]);
        } else 
        {
            return $this->redirectToRoute('app_login');
        }
    }
}
