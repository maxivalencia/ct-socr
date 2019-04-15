<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class CtController extends AbstractController
{
    /**
     * @Route("/home", name="ct_homepage")
     */
    public function index()
    {
        //if(!empty($_SESSION['username']))
        //{
            return $this->render('ct/ct.html.twig', [
                'controller_name' => 'CtController',
            ]);
        //} else 
        //{
            //return $this->redirectToRoute('app_login');
        //}
    }

    /**
     * @Route("/profil", name="ct_profil")
     */
    public function profil(){
        //gestion de la vision de la profil utilisateur
        $user = new User();
        //$username = $this->container->get('security.context')->getToken()->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser()->getId());
        //$user = $repository->findOneBy(['username' => $username]);
        return $this->render('ct/profil.html.twig', [
            'users' => $user,
        ]);
    }

    /**
     * @Route("/", name="ct_base")
     */
    public function rediriger()
    {
        if(!empty($_SESSION['username']))
        {
            return $this->redirectToRoute('ct_profil');
        } else 
        {
            return $this->redirectToRoute('app_login');
        }
    }
}
