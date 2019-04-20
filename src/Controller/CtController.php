<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Controles;
use App\Entity\Roles;
use App\Entity\Centres;

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
    public function rediriger(){
        if(!empty($_SESSION['username']))
        {
            return $this->redirectToRoute('ct_profil');
        } else 
        {
            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/statistique", name="ct_statistique")
     */
    public function statistique(){
        $role = new Roles();
        $role = $this->getDoctrine()->getRepository(Roles::class)->findOneBy(['role' => 'VERIFICATEUR']);
        $role_id = $role->getId();
        $user = new User();
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(['role' => $role_id]);
        $verificateur = count($user);
        $controle = new Controles();
        $controle = $this->getDoctrine()->getRepository(Controles::class)->findAll();
        $controlerealiser = count($controle);
        $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
        $papierrestant = count($controle);
        $papierretirer = $controlerealiser - $papierrestant;
        $centre = new Centres();
        $centre = $this->getDoctrine()->getRepository(Centres::class)->findAll();
        $nombre_centre = count($centre);
        return $this->render('ct/stat.html.twig', [
            'controlerealiser' => $controlerealiser,
            'papierretirer' => $papierretirer,
            'papierrestant' => $papierrestant,
            'nombreverificateur' => $verificateur,
            'nombrecentre' => $nombre_centre,
        ]);
    }
}
