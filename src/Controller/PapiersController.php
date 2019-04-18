<?php

namespace App\Controller;

use App\Entity\Papiers;
use App\Form\PapiersType;
use App\Repository\PapiersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/papiers")
 */
class PapiersController extends AbstractController
{
    /**
     * @Route("/", name="papiers_index", methods={"GET"})
     */
    public function index(PapiersRepository $papiersRepository): Response
    {
        return $this->render('papiers/index.html.twig', [
            'papiers' => $papiersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="papiers_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $papier = new Papiers();
        $form = $this->createForm(PapiersType::class, $papier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($papier);
            $entityManager->flush();

            return $this->redirectToRoute('papiers_index');
        }

        return $this->render('papiers/new.html.twig', [
            'papier' => $papier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="papiers_show", methods={"GET"})
     */
    public function show(Papiers $papier): Response
    {
        return $this->render('papiers/show.html.twig', [
            'papier' => $papier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="papiers_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Papiers $papier): Response
    {
        $form = $this->createForm(PapiersType::class, $papier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('papiers_index', [
                'id' => $papier->getId(),
            ]);
        }

        return $this->render('papiers/edit.html.twig', [
            'papier' => $papier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="papiers_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Papiers $papier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$papier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($papier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('papiers_index');
    }
}
