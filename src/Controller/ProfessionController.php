<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfessionController extends AbstractController
{
    /**
     * @Route("/profession", name="profession")
     */
    public function index()
    {
        return $this->render('profession/index.html.twig', [
            'controller_name' => 'ProfessionController',
        ]);
    }
}
