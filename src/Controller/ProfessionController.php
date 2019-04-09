<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Profession;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProfessionFormType;

class ProfessionController extends AbstractController
{
    /**
     * @Route("/profession", name="profession")
     */
    public function profession(Request $request)
    {
        $profession = new Profession();
        $profession->setProfession('profession');

        $form = $this->createForm(ProfessionFormType::class, $profession);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profession = $form->getData();
            return $this->redirectToRoute('profession');
        }

        return $this->render('profession/profession.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
