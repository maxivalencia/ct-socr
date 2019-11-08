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
use Carbon\Carbon;

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
    public function statistique(Request $request){
        $parametre = $request->query->get('page');
        switch($parametre) {
            case "hebdo" :
                $role = new Roles();
                $role = $this->getDoctrine()->getRepository(Roles::class)->findOneBy(['role' => 'VERIFICATEUR']);
                $role_id = $role->getId();
                $user = new User();
                $user = $this->getDoctrine()->getRepository(User::class)->findBy(['role' => $role_id]);
                $verificateur = 0;
                foreach($user as $us){
                    if($us->getCentre() == $this->getUser()->getCentre()){
                        $verificateur++;
                    }
                }
                $controle = new Controles();
                $now = Carbon::now();
                $date = Carbon::now()->subWeek();
                //
                $controle = $this->getDoctrine()->getRepository(Controles::class)->findAll(['centre' => $this->getUser()->getCentre()]);$controle = $this->getDoctrine()->getRepository(Controles::class)->getDays($now, $date);
                $controle = $this->getDoctrine()->getRepository(Controles::class)->findAll(['centre' => $this->getUser()->getCentre()]);
                $controlerealiser = 0;
                foreach($controle as $cont){
                    if($cont->getCentre() == $this->getUser()->getCentre() && intval(date_diff($cont->getCreatedAt(), new \DateTime())->format("%d")) < 7){
                        $controlerealiser++;
                    }
                }
                $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
                $papierrestant = 0;
                foreach($controle as $cont){
                    if($cont->getCentre() == $this->getUser()->getCentre()){
                        $papierrestant++;
                    }
                }
                $papierretirer = $controlerealiser - $papierrestant;
                if($papierretirer < 0){
                    $papierretirer = 0;
                }
                $centre = new Centres();
                $centre = $this->getDoctrine()->getRepository(Centres::class)->findAll();
                $nombre_centre = 0;
                foreach($centre as $cent){
                    if($cent->getCentre() == $this->getUser()->getCentre()){
                        $nombre_centre++;
                    }
                }
                return $this->render('ct/stat.html.twig', [
                    'controlerealiser' => $controlerealiser,
                    'papierretirer' => $papierretirer,
                    'papierrestant' => $papierrestant,
                    'nombreverificateur' => $verificateur,
                    'nombrecentre' => $nombre_centre,
                ]);
                break;
            case "mensuel" :
                $role = new Roles();
                $role = $this->getDoctrine()->getRepository(Roles::class)->findOneBy(['role' => 'VERIFICATEUR']);
                $role_id = $role->getId();
                $user = new User();
                $user = $this->getDoctrine()->getRepository(User::class)->findBy(['role' => $role_id]);
                $verificateur =  0;
                foreach($user as $us){
                    if($us->getCentre() == $this->getUser()->getCentre()){
                        $verificateur++;
                    }
                }
                $controle = new Controles();
                $now = new \DateTime();
                $date = Carbon::now()->subMonth();
                //$controle = $this->getDoctrine()->getRepository(Controles::class)->getDays($now, $date);
                $controle = $this->getDoctrine()->getRepository(Controles::class)->findAll(['centre' => $this->getUser()->getCentre()]);
                $controlerealiser = 0;
                foreach($controle as $cont){
                    if($cont->getCentre() == $this->getUser()->getCentre() && intval(date_diff($cont->getCreatedAt(), new \DateTime())->format("%d")) < 30){
                        $controlerealiser++;
                    }
                }
                $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
                $papierrestant = 0;
                foreach($controle as $cont){
                    if($cont->getCentre() == $this->getUser()->getCentre()){
                        $papierrestant++;
                    }
                }
                $papierretirer = $controlerealiser - $papierrestant;
                if($papierretirer < 0){
                    $papierretirer = 0;
                }
                $centre = new Centres();
                $centre = $this->getDoctrine()->getRepository(Centres::class)->findAll();
                $nombre_centre = 0;
                foreach($centre as $cent){
                    if($cent->getCentre() == $this->getUser()->getCentre()){
                        $nombre_centre++;
                    }
                }
                return $this->render('ct/stat.html.twig', [
                    'controlerealiser' => $controlerealiser,
                    'papierretirer' => $papierretirer,
                    'papierrestant' => $papierrestant,
                    'nombreverificateur' => $verificateur,
                    'nombrecentre' => $nombre_centre,
                ]);
                break;
            case "annuel" :
                $role = new Roles();
                $role = $this->getDoctrine()->getRepository(Roles::class)->findOneBy(['role' => 'VERIFICATEUR']);
                $role_id = $role->getId();
                $user = new User();
                $user = $this->getDoctrine()->getRepository(User::class)->findBy(['role' => $role_id]);
                $verificateur = 0;
                foreach($user as $us){
                    if($us->getCentre() == $this->getUser()->getCentre()){
                        $verificateur++;
                    }
                }
                $controle = new Controles();
                $now = new \DateTime();
                $date = Carbon::now()->subYear();
                //$controle = $this->getDoctrine()->getRepository(Controles::class)->getDays($now, $date);
                $controle = $this->getDoctrine()->getRepository(Controles::class)->findAll(['centre' => $this->getUser()->getCentre()]);
                $controlerealiser = 0;
                foreach($controle as $cont){
                    if($cont->getCentre() == $this->getUser()->getCentre() && intval(date_diff($cont->getCreatedAt(), new \DateTime())->format("%d")) < 365){
                        $controlerealiser++;
                    }
                }
                $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
                $papierrestant = 0;
                foreach($controle as $cont){
                    if($cont->getCentre() == $this->getUser()->getCentre()){
                        $papierrestant++;
                    }
                }
                $papierretirer = $controlerealiser - $papierrestant;
                if($papierretirer < 0){
                    $papierretirer = 0;
                }
                $centre = new Centres();
                $centre = $this->getDoctrine()->getRepository(Centres::class)->findAll();
                $nombre_centre = 0;
                foreach($centre as $cent){
                    if($cent->getCentre() == $this->getUser()->getCentre()){
                        $nombre_centre++;
                    }
                }
                return $this->render('ct/stat.html.twig', [
                    'controlerealiser' => $controlerealiser,
                    'papierretirer' => $papierretirer,
                    'papierrestant' => $papierrestant,
                    'nombreverificateur' => $verificateur,
                    'nombrecentre' => $nombre_centre,
                ]);
                break;
            default :
                $role = new Roles();
                $role = $this->getDoctrine()->getRepository(Roles::class)->findOneBy(['role' => 'VERIFICATEUR']);
                $role_id = $role->getId();
                $user = new User();
                $user = $this->getDoctrine()->getRepository(User::class)->findBy(['role' => $role_id]);
                $verificateur = 0;
                foreach($user as $us){
                    if($us->getCentre() == $this->getUser()->getCentre()){
                        $verificateur++;
                    }
                }
                $controle = new Controles();
                //$user2 = $this->getDoctrine()->getRepository(User::class)->findOne($this->getUser()->getId())
                $controle = $this->getDoctrine()->getRepository(Controles::class)->findAll(['centre' => $this->getUser()->getCentre()]);
                $controlerealiser = 0;
                foreach($controle as $cont){
                    if($cont->getCentre() == $this->getUser()->getCentre()){
                        $controlerealiser++;
                    }
                }
                $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
                $papierrestant = 0;
                foreach($controle as $cont){
                    if($cont->getCentre() == $this->getUser()->getCentre()){
                        $papierrestant++;
                    }
                }
                $papierretirer = $controlerealiser - $papierrestant;
                if($papierretirer < 0){
                    $papierretirer = 0;
                }
                $centre = new Centres();
                $centre = $this->getDoctrine()->getRepository(Centres::class)->findAll();
                $nombre_centre = 0;
                foreach($centre as $cent){
                    if($cent->getCentre() == $this->getUser()->getCentre()){
                        $nombre_centre++;
                    }
                }
                return $this->render('ct/stat.html.twig', [
                    'controlerealiser' => $controlerealiser,
                    'papierretirer' => $papierretirer,
                    'papierrestant' => $papierrestant,
                    'nombreverificateur' => $verificateur,
                    'nombrecentre' => $nombre_centre,
                ]);
                break;
        }
    }

    /**
     * @Route("/historique", name="historique_index", methods={"GET"})
     */
    public function historique(\App\Repository\ControlesRepository $controlesRepository, Request $request): Response
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
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $logo = $this->getParameter('image').'/logo_dgsr.png';
        $html = $this->renderView('ct/pdfsaisie.html.twig', [
            'controle' => $controle,
            'logo' => $logo,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $fichier = $controle->getImmatriculation();
        $dompdf->stream("Controle_".$fichier.".pdf", [
            "Attachment" => true
        ]);

    }

    /**
     * @Route("/pdfcontrole", name="pdfcontrole", methods={"GET"})
     */
    public function pdfControle(Request $request): Response
    {
        $role = new Roles();
        $role = $this->getDoctrine()->getRepository(Roles::class)->findOneBy(['role' => 'VERIFICATEUR']);
        $role_id = $role->getId();
        $user = new User();
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(['role' => $role_id]);
        $verificateur = 0;
        foreach($user as $us){
            if($us->getCentre() == $this->getUser()->getCentre()){
                $verificateur++;
            }
        }
        $controle = new Controles();
        $controle = $this->getDoctrine()->getRepository(Controles::class)->findAll(['centre' => $this->getUser()->getCentre()]);
        $controlerealiser = 0;
        foreach($controle as $cont){
            if($cont->getCentre() == $this->getUser()->getCentre()){
                $controlerealiser++;
            }
        }
        $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
        $papierrestant = 0;
        foreach($controle as $cont){
            if($cont->getCentre() == $this->getUser()->getCentre()){
                $papierrestant++;
            }
        }
        $papierretirer = $controlerealiser - $papierrestant;
        if($papierretirer < 0){
            $papierretirer = 0;
        }
        $centre = new Centres();
        $centre = $this->getDoctrine()->getRepository(Centres::class)->findAll();
        $nombre_centre = 0;
        foreach($centre as $cent){
            if($cent->getCentre() == $this->getUser()->getCentre()){
                $nombre_centre++;
            }
        }
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $logo = $this->getParameter('image').'/logo_dgsr.png';
        $html = $this->renderView('ct/pdfcontrole.html.twig', [
            'controle' => '',
            'logo' => $logo,
            'controlerealiser' => $controlerealiser,
            'papierretirer' => $papierretirer,
            'papierrestant' => $papierrestant,
            'nombreverificateur' => $verificateur,
            'nombrecentre' => $nombre_centre,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Statistique_Controle.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route("/pdfcontroleannuel", name="pdfcontroleannuel", methods={"GET"})
     */
    public function pdfControleAnnuel(Request $request): Response
    {
        $role = new Roles();
        $role = $this->getDoctrine()->getRepository(Roles::class)->findOneBy(['role' => 'VERIFICATEUR']);
        $role_id = $role->getId();
        $user = new User();
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(['role' => $role_id]);
        $verificateur = 0;
        foreach($user as $us){
            if($us->getCentre() == $this->getUser()->getCentre()){
                $verificateur++;
            }
        }
        $controle = new Controles();
        $now = new \DateTime();
        $date = Carbon::now()->subYear();
        $controle = $this->getDoctrine()->getRepository(Controles::class)->findAll(['centre' => $this->getUser()->getCentre()]);
        $controlerealiser = 0;
        foreach($controle as $cont){
            if($cont->getCentre() == $this->getUser()->getCentre() && intval(date_diff($cont->getCreatedAt(), new \DateTime())->format("%d")) < 365){
                $controlerealiser++;
            }
        }
        $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
        $papierrestant = 0;
        foreach($controle as $cont){
            if($cont->getCentre() == $this->getUser()->getCentre()){
                $papierrestant++;
            }
        }
        $papierretirer = $controlerealiser - $papierrestant;
        if($papierretirer < 0){
            $papierretirer = 0;
        }
        $centre = new Centres();
        $centre = $this->getDoctrine()->getRepository(Centres::class)->findAll();
        $nombre_centre = 0;
        foreach($centre as $cent){
            if($cent->getCentre() == $this->getUser()->getCentre()){
                $nombre_centre++;
            }
        }
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $logo = $this->getParameter('image').'/logo_dgsr.png';
        $html = $this->renderView('ct/pdfcontrole.html.twig', [
            'controle' => 'de l\'année à ce jour',
            'logo' => $logo,
            'controlerealiser' => $controlerealiser,
            'papierretirer' => $papierretirer,
            'papierrestant' => $papierrestant,
            'nombreverificateur' => $verificateur,
            'nombrecentre' => $nombre_centre,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Statistique_Controle_Annuel.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route("/pdfcontrolemensuel", name="pdfcontrolemensuel", methods={"GET"})
     */
    public function pdfControleMensuel(Request $request): Response
    {
        $role = new Roles();
        $role = $this->getDoctrine()->getRepository(Roles::class)->findOneBy(['role' => 'VERIFICATEUR']);
        $role_id = $role->getId();
        $user = new User();
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(['role' => $role_id]);
        $verificateur = 0;
        foreach($user as $us){
            if($us->getCentre() == $this->getUser()->getCentre()){
                $verificateur++;
            }
        }
        $controle = new Controles();
        $now = new \DateTime();
        $date = Carbon::now()->subYear();
        $controle = $this->getDoctrine()->getRepository(Controles::class)->findAll(['centre' => $this->getUser()->getCentre()]);
        $controlerealiser = 0;
        foreach($controle as $cont){
            if($cont->getCentre() == $this->getUser()->getCentre() && intval(date_diff($cont->getCreatedAt(), new \DateTime())->format("%d")) < 30){
                $controlerealiser++;
            }
        }
        $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
        $papierrestant = 0;
        foreach($controle as $cont){
            if($cont->getCentre() == $this->getUser()->getCentre()){
                $papierrestant++;
            }
        }
        $papierretirer = $controlerealiser - $papierrestant;
        if($papierretirer < 0){
            $papierretirer = 0;
        }
        $centre = new Centres();
        $centre = $this->getDoctrine()->getRepository(Centres::class)->findAll();
        $nombre_centre = 0;
        foreach($centre as $cent){
            if($cent->getCentre() == $this->getUser()->getCentre()){
                $nombre_centre++;
            }
        }
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $logo = $this->getParameter('image').'/logo_dgsr.png';
        $html = $this->renderView('ct/pdfcontrole.html.twig', [
            'controle' => 'du 30 derniers jours',
            'logo' => $logo,
            'controlerealiser' => $controlerealiser,
            'papierretirer' => $papierretirer,
            'papierrestant' => $papierrestant,
            'nombreverificateur' => $verificateur,
            'nombrecentre' => $nombre_centre,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Statistique_Controle_Mensuel.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route("/pdfcontrolehebdomadaire", name="pdfcontrolehebdomadaire", methods={"GET"})
     */
    public function pdfControleHebdomadaire(Request $request): Response
    {
        $role = new Roles();
        $role = $this->getDoctrine()->getRepository(Roles::class)->findOneBy(['role' => 'VERIFICATEUR']);
        $role_id = $role->getId();
        $user = new User();
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(['role' => $role_id]);
        $verificateur = 0;
        foreach($user as $us){
            if($us->getCentre() == $this->getUser()->getCentre()){
                $verificateur++;
            }
        }
        $controle = new Controles();
        $now = new \DateTime();
        $date = Carbon::now()->subYear();
        $controle = $this->getDoctrine()->getRepository(Controles::class)->findAll(['centre' => $this->getUser()->getCentre()]);
        $controlerealiser = 0;
        foreach($controle as $cont){
            if($cont->getCentre() == $this->getUser()->getCentre() && intval(date_diff($cont->getCreatedAt(), new \DateTime())->format("%d")) < 7){
                $controlerealiser++;
            }
        }
        $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
        $papierrestant = 0;
        foreach($controle as $cont){
            if($cont->getCentre() == $this->getUser()->getCentre()){
                $papierrestant++;
            }
        }
        $papierretirer = $controlerealiser - $papierrestant;
        if($papierretirer < 0){
            $papierretirer = 0;
        }
        $centre = new Centres();
        $centre = $this->getDoctrine()->getRepository(Centres::class)->findAll();
        $nombre_centre = 0;
        foreach($centre as $cent){
            if($cent->getCentre() == $this->getUser()->getCentre()){
                $nombre_centre++;
            }
        }
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $logo = $this->getParameter('image').'/logo_dgsr.png';
        $html = $this->renderView('ct/pdfcontrole.html.twig', [
            'controle' => 'du 7 derniers jours',
            'logo' => $logo,
            'controlerealiser' => $controlerealiser,
            'papierretirer' => $papierretirer,
            'papierrestant' => $papierrestant,
            'nombreverificateur' => $verificateur,
            'nombrecentre' => $nombre_centre,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Statistique_Controle_Hebdomadaire.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route("/pdfhistorique", name="pdfhistorique", methods={"GET"})
     */
    public function pdfHistorique(\App\Repository\ControlesRepository $controlesRepository, Request $request): Response
    {
        $recherche = $request->query->get('recherche');
        if($recherche){
            $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
            $papierrestant = count($controle);
            $nb_ligne_page = 20;
            $nombre_page = (int)(ceil($papierrestant / $nb_ligne_page));
            $numero_page = $request->query->get('page')?(int)$request->query->get('page'):1;
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            $dompdf = new Dompdf($pdfOptions);
            $logo = $this->getParameter('image').'/logo_dgsr.png';
            $html = $this->renderView('ct/pdfcontrole.html.twig', [
                'controle' => 'du 7 derniers jours',
                'logo' => $logo,
                'controles' => $controlesRepository->findBy(['Immatriculation' => strtoupper($recherche)], ['id' => 'DESC'], $nb_ligne_page*$numero_page, $numero_page-1),
                'nombre_page' => $nombre_page,
                'premiere_page' => 1,
                'derniere_page' => $nombre_page,
                'page_precedent' => ($numero_page-1)<1?1:($numero_page-1),
                'page_suivant' => ($numero_page+1)>=$nombre_page?$nombre_page:($numero_page+1),
                'numero_page' => $numero_page,
            ]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream("Historique_Controle.pdf", [
                "Attachment" => true
            ]);
        }
        else{
            $controle = $this->getDoctrine()->getRepository(Controles::class)->findBy(['retireur' => null]);
            $papierrestant = count($controle);
            $nb_ligne_page = 20;
            $nombre_page = (int)(ceil($papierrestant / $nb_ligne_page));
            $numero_page = $request->query->get('page')?(int)$request->query->get('page'):1;
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            $dompdf = new Dompdf($pdfOptions);
            $logo = $this->getParameter('image').'/logo_dgsr.png';
            $html = $this->renderView('ct/pdfhistorique.html.twig', [                
                'logo' => $logo,
                'controles' => $controlesRepository->findAll(['id' => 'DESC'], $nb_ligne_page*$numero_page, $numero_page-1),
                'nombre_page' => $nombre_page,
                'premiere_page' => 1,
                'derniere_page' => $nombre_page,
                'page_precedent' => ($numero_page-1)<1?1:($numero_page-1),
                'page_suivant' => ($numero_page+1)>=$nombre_page?$nombre_page:($numero_page+1),
                'numero_page' => $numero_page,
            ]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $dompdf->stream("Historique_Controle.pdf", [
                "Attachment" => true
            ]);
        }
    }
}
