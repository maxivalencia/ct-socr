<?php

namespace App\Controller;

use App\Entity\Anomalies;
use App\Form\AnomaliesType;
use App\Repository\AnomaliesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/anomalies")
 */
class AnomaliesController extends AbstractController
{
    /**
     * @Route("/", name="anomalies_index", methods={"GET"})
     */
    public function index(AnomaliesRepository $anomaliesRepository, Request $request): Response
    {
        $anomalie = $this->getDoctrine()->getRepository(Anomalies::class)->findAll();
        $papierrestant = count($anomalie);
        $nb_ligne_page = 10;
        $nombre_page = (int)(ceil($papierrestant / $nb_ligne_page));
        $numero_page = $request->query->get('page')?(int)$request->query->get('page'):1;
        
        return $this->render('anomalies/index.html.twig', [
            'anomalies' => $anomaliesRepository->findAll([],[], $nb_ligne_page*$numero_page, $numero_page-1),
            'nombre_page' => $nombre_page,
            'premiere_page' => 1,
            'derniere_page' => $nombre_page,
            'page_precedent' => ($numero_page-1)<1?1:($numero_page-1),
            'page_suivant' => ($numero_page+1)>=$nombre_page?$nombre_page:($numero_page+1),
            'numero_page' => $numero_page,
        ]);
    }

    /**
     * @Route("/new", name="anomalies_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $anomaly = new Anomalies();
        $form = $this->createForm(AnomaliesType::class, $anomaly);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($anomaly);
            $entityManager->flush();

            return $this->redirectToRoute('anomalies_index');
        }

        return $this->render('anomalies/new.html.twig', [
            'anomaly' => $anomaly,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="anomalies_show", methods={"GET"})
     */
    public function show(Anomalies $anomaly): Response
    {
        return $this->render('anomalies/show.html.twig', [
            'anomaly' => $anomaly,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="anomalies_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Anomalies $anomaly): Response
    {
        $form = $this->createForm(AnomaliesType::class, $anomaly);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('anomalies_index', [
                'id' => $anomaly->getId(),
            ]);
        }

        return $this->render('anomalies/edit.html.twig', [
            'anomaly' => $anomaly,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="anomalies_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Anomalies $anomaly): Response
    {
        if ($this->isCsrfTokenValid('delete'.$anomaly->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($anomaly);
            $entityManager->flush();
        }

        return $this->redirectToRoute('anomalies_index');
    }
}
