<?php

namespace App\Controller;

use App\Entity\Centres;
use App\Form\CentresType;
use App\Repository\CentresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/centres")
 */
class CentresController extends AbstractController
{
    /**
     * @Route("/", name="centres_index", methods={"GET"})
     */
    public function index(CentresRepository $centresRepository): Response
    {
        return $this->render('centres/index.html.twig', [
            'centres' => $centresRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="centres_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $centre = new Centres();
        $form = $this->createForm(CentresType::class, $centre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($centre);
            $entityManager->flush();

            return $this->redirectToRoute('centres_index');
        }

        return $this->render('centres/new.html.twig', [
            'centre' => $centre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="centres_show", methods={"GET"})
     */
    public function show(Centres $centre): Response
    {
        return $this->render('centres/show.html.twig', [
            'centre' => $centre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="centres_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Centres $centre): Response
    {
        $form = $this->createForm(CentresType::class, $centre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('centres_index', [
                'id' => $centre->getId(),
            ]);
        }

        return $this->render('centres/edit.html.twig', [
            'centre' => $centre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="centres_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Centres $centre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$centre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($centre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('centres_index');
    }
}
