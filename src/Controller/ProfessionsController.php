<?php

namespace App\Controller;

use App\Entity\Professions;
use App\Form\ProfessionsType;
use App\Repository\ProfessionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/professions")
 */
class ProfessionsController extends AbstractController
{
    /**
     * @Route("/", name="professions_index", methods={"GET"})
     */
    public function index(ProfessionsRepository $professionsRepository): Response
    {
        return $this->render('professions/index.html.twig', [
            'professions' => $professionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="professions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $profession = new Professions();
        $form = $this->createForm(ProfessionsType::class, $profession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profession);
            $entityManager->flush();

            return $this->redirectToRoute('professions_index');
        }

        return $this->render('professions/new.html.twig', [
            'profession' => $profession,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="professions_show", methods={"GET"})
     */
    public function show(Professions $profession): Response
    {
        return $this->render('professions/show.html.twig', [
            'profession' => $profession,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="professions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Professions $profession): Response
    {
        $form = $this->createForm(ProfessionsType::class, $profession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('professions_index', [
                'id' => $profession->getId(),
            ]);
        }

        return $this->render('professions/edit.html.twig', [
            'profession' => $profession,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="professions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Professions $profession): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profession->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profession);
            $entityManager->flush();
        }

        return $this->redirectToRoute('professions_index');
    }
}
