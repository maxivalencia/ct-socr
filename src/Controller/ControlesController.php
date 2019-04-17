<?php

namespace App\Controller;

use App\Entity\Controles;
use App\Form\ControlesType;
use App\Repository\ControlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/controles")
 */
class ControlesController extends AbstractController
{
    /**
     * @Route("/", name="controles_index", methods={"GET"})
     */
    public function index(ControlesRepository $controlesRepository): Response
    {
        return $this->render('controles/index.html.twig', [
            'controles' => $controlesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="controles_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $controle = new Controles();
        $form = $this->createForm(ControlesType::class, $controle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $controle->setCreatedAt(new \DateTime());
            $entityManager->persist($controle);
            $entityManager->flush();

            return $this->redirectToRoute('controles_index');
        }

        return $this->render('controles/new.html.twig', [
            'controle' => $controle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="controles_show", methods={"GET"})
     */
    public function show(Controles $controle): Response
    {
        return $this->render('controles/show.html.twig', [
            'controle' => $controle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="controles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Controles $controle): Response
    {
        $form = $this->createForm(ControlesType::class, $controle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('controles_index', [
                'id' => $controle->getId(),
            ]);
        }

        return $this->render('controles/edit.html.twig', [
            'controle' => $controle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="controles_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Controles $controle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$controle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($controle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('controles_index');
    }
}
