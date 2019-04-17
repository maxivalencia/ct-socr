<?php

namespace App\Controller;

use App\Entity\Utilisations;
use App\Form\UtilisationsType;
use App\Repository\UtilisationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/utilisations")
 */
class UtilisationsController extends AbstractController
{
    /**
     * @Route("/", name="utilisations_index", methods={"GET"})
     */
    public function index(UtilisationsRepository $utilisationsRepository): Response
    {
        return $this->render('utilisations/index.html.twig', [
            'utilisations' => $utilisationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="utilisations_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $utilisation = new Utilisations();
        $form = $this->createForm(UtilisationsType::class, $utilisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisation);
            $entityManager->flush();

            return $this->redirectToRoute('utilisations_index');
        }

        return $this->render('utilisations/new.html.twig', [
            'utilisation' => $utilisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="utilisations_show", methods={"GET"})
     */
    public function show(Utilisations $utilisation): Response
    {
        return $this->render('utilisations/show.html.twig', [
            'utilisation' => $utilisation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="utilisations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Utilisations $utilisation): Response
    {
        $form = $this->createForm(UtilisationsType::class, $utilisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisations_index', [
                'id' => $utilisation->getId(),
            ]);
        }

        return $this->render('utilisations/edit.html.twig', [
            'utilisation' => $utilisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="utilisations_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Utilisations $utilisation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($utilisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('utilisations_index');
    }
}
