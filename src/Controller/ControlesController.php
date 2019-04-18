<?php

namespace App\Controller;

use App\Entity\Controles;
use App\Form\ControlesType;
use App\Repository\ControlesRepository;
use App\Repository\AnomaliesRepository;
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
    public function index(AnomaliesRepository $anomaliesRepository, ControlesRepository $controlesRepository, Request $request): Response
    {
        $recherche = $request->query->get('recherche');
        if($recherche){
            return $this->render('controles/index.html.twig', [
                'controles' => $controlesRepository->findBy(['Immatriculation' => strtoupper($recherche), 'retireur' => null]),
            ]);
        }
        else{
            //$controles=$controlesRepository->findAll();
            //foreach($controle as $controles){

            //}
            return $this->render('controles/index.html.twig', [
                'controles' => $controlesRepository->findBy(['retireur' => null]),
                //'anomaliescol' => $anomaliesRepository->findABy('id' => ),
            ]);
        }
    }

    /**
     * @Route("/new", name="controles_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $controle = new Controles();
        $form = $this->createForm(ControlesType::class, $controle);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $controle->setCreatedAt(new \DateTime());
            $controle->setAnomalies('source');
            $controle->setPapiersRetirers(true);
            $controle->setAjouteur($user);
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
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            //$controle->setAnomalies('source');
            //$controle->setPapiersRetirers(true);
            //$controle->setAjouteur($user);
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

    /**
     * @Route("/{id}/retirer", name="controles_retirer", methods={"GET","POST"})
     */
    public function retirer(Controles $controle): Response
    {
        //$form = $this->createForm(ControlesType::class, $controle);
        //$form->handleRequest($request);
        $user = $this->getUser();

        //if ($form->isSubmitted() && $form->isValid()) {
            //$controle->setAnomalies('source');
            //$controle->setPapiersRetirers(true);
            //$controle->setAjouteur($user);
            $controle->setRetireur($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('controles_index');
        //}

        /*return $this->render('controles/edit.html.twig', [
            'controle' => $controle,
            'form' => $form->createView(),
        ]);*/
    }
}
