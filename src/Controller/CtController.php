<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Controles;
use App\Entity\Roles;
use App\Entity\Centres;
use App\Repository\ControlesRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

class CtController extends AbstractController
{
    private $knpSnappy;

    public function __construct(\Knp\Snappy\Pdf $knpSnappy) {
        $this->knpSnappy = $knpSnappy;
    }

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

    /**
     * @Route("/historique", name="historique_index", methods={"GET"})
     */
    public function historique(ControlesRepository $controlesRepository, Request $request): Response
    {
        $recherche = $request->query->get('recherche');
        if($recherche){
            $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
            $papierrestant = count($controle);
            $nb_ligne_page = 20;
            $nombre_page = (int)(ceil($papierrestant / $nb_ligne_page));
            $numero_page = $request->query->get('page')?(int)$request->query->get('page'):1;
            return $this->render('ct/historique.html.twig', [
                'controles' => $controlesRepository->findBy(['Immatriculation' => strtoupper($recherche)], ['id' => 'DESC'], $nb_ligne_page*$numero_page, $numero_page-1),
                'nombre_page' => $nombre_page,
                'premiere_page' => 1,
                'derniere_page' => $nombre_page,
                'page_precedent' => ($numero_page-1)<1?1:($numero_page-1),
                'page_suivant' => ($numero_page+1)>=$nombre_page?$nombre_page:($numero_page+1),
                'numero_page' => $numero_page,
            ]);
        }
        else{
            $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
            $papierrestant = count($controle);
            $nb_ligne_page = 20;
            $nombre_page = (int)(ceil($papierrestant / $nb_ligne_page));
            $numero_page = $request->query->get('page')?(int)$request->query->get('page'):1;
            
            return $this->render('ct/historique.html.twig', [
                'controles' => $controlesRepository->findAll(['id' => 'DESC'], $nb_ligne_page*$numero_page, $numero_page-1),
                'nombre_page' => $nombre_page,
                'premiere_page' => 1,
                'derniere_page' => $nombre_page,
                'page_precedent' => ($numero_page-1)<1?1:($numero_page-1),
                'page_suivant' => ($numero_page+1)>=$nombre_page?$nombre_page:($numero_page+1),
                'numero_page' => $numero_page,
            ]);
        }
    }

    /**
     * @Route("/historique/{id}", name="historique_show", methods={"GET"})
     */
    public function show(Controles $controle): Response
    {
        return $this->render('ct/historique_show.html.twig', [
            'controle' => $controle,
        ]);
    }

    /**
     * @Route("/{id}/pdf", name="pdf", methods={"GET"})
     */
    public function pdf(Controles $controle): Response
    {
        /*$html = $this->renderView('ct/pdfsaisie.html.twig');
        $snappy = $this->get('knp_snappy.pdf');
        $fichier = 'controle';

        return new Response(
            $this->KnpSnappy->getOutputFromHtml($html),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"',$fichier.'.pdf'),
            ]
        );*/
        //$controle = 
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('ct/pdfsaisie.html.twig', [
            'controle' => $controle
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);

    }

}
