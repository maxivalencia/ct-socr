<?php

namespace App\Controller;

use App\Entity\AnomaliesType;
use App\Form\AnomaliesTypeType;
use App\Repository\AnomaliesTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/anomalietype")
 */
class AnomaliesTypeController extends AbstractController
{
    /**
     * @Route("/", name="anomalies_type_index", methods={"GET"})
     */
    public function index(AnomaliesTypeRepository $anomaliesTypeRepository): Response
    {
        return $this->render('anomalies_type/index.html.twig', [
            'anomalies_types' => $anomaliesTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="anomalies_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $anomaliesType = new AnomaliesType();
        $form = $this->createForm(AnomaliesTypeType::class, $anomaliesType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($anomaliesType);
            $entityManager->flush();

            return $this->redirectToRoute('anomalies_type_index');
        }

        return $this->render('anomalies_type/new.html.twig', [
            'anomalies_type' => $anomaliesType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="anomalies_type_show", methods={"GET"})
     */
    public function show(AnomaliesType $anomaliesType): Response
    {
        return $this->render('anomalies_type/show.html.twig', [
            'anomalies_type' => $anomaliesType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="anomalies_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AnomaliesType $anomaliesType): Response
    {
        $form = $this->createForm(AnomaliesTypeType::class, $anomaliesType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('anomalies_type_index', [
                'id' => $anomaliesType->getId(),
            ]);
        }

        return $this->render('anomalies_type/edit.html.twig', [
            'anomalies_type' => $anomaliesType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="anomalies_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AnomaliesType $anomaliesType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$anomaliesType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($anomaliesType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('anomalies_type_index');
    }
}
