<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\UserRepository;
use App\Repository\AnomaliesRepository;
use App\Repository\PapiersRepository;
use App\Repository\PhotoRepository;
use App\Entity\User;
use App\Entity\Controles;
use App\Entity\Photo;
use App\Repository\ControlesRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
/* use Symfony\Contracts\HttpClient\HttpClientInterface; */

/**
 * @Route("/cri")
 */
class CriServiceController extends AbstractController
{
    
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    /**
     * @Route("/service", name="cri_service")
     */
    public function index()
    {
        return $this->render('cri_service/index.html.twig', [
            'controller_name' => 'CriServiceController',
        ]);
    }

    /**
     * @Route("/anomalies", name="liste_anomalie", methods={"GET","POST"})
     */
    public function ListeAnomalies(AnomaliesRepository $anomaliesRepository)//: Response
    {
        $liste_anomalies = new ArrayCollection();
        $liste_anomalies_base = $anomaliesRepository->findAll();
        foreach($liste_anomalies_base as $lab){
            $anomalie = [
                "id" => $lab->getId(),
                "code" => $lab->getCodeAnomalie(),
            ];
            $liste_anomalies->add($anomalie);
        }
        $response = new JsonResponse($liste_anomalies->toArray());
        $response->headers->set('Access-Control-Allow-Headers', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');

        return $response;
    }

    /**
     * @Route("/papiers", name="liste_papiers", methods={"GET","POST"})
     */
    public function ListePapiers(PapiersRepository $papiersRepository)//: Response
    {
        $liste_papiers = new ArrayCollection();
        $liste_papiers_base = $papiersRepository->findAll();
        foreach($liste_papiers_base as $lpb){
            $papier = [
                "id" => $lpb->getId(),
                "papier" => $lpb->getPapier(),
            ];
            $liste_papiers->add($papier);
        }
        $response = new JsonResponse($liste_papiers->toArray());
        $response->headers->set('Access-Control-Allow-Headers', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');

        return $response;
    }

    /**
     * @Route("/login/service", name="login_service", methods={"GET", "POST"})
     */
    public function LoginService(Request $request, UserRepository $userRepository)//: Response
    {
        $user = new User();
        $id_user = 0;
        $code = 0;
        $message = "";
        if($request->query->get("username") && $request->query->get("password")){
            $username = $request->query->get("username");
            $password = $request->query->get("password");
            $user = $userRepository->findOneBy(["username" => $username]);

            if($user != null){
                if($user->getId() != null){
                    $password_hashed = $this->passwordEncoder->encodePassword($user, $password);
                    if($this->passwordEncoder->isPasswordValid($user, $password)){
                        $id_user = $user->getId();
                        $code = 200;
                        $message = "Utilisateur connecté";
                    } else{
                        $id_user = 0;
                        $code = 402;
                        $message = "veuillez fournir un mot de pass valide pour cette application";
                    }
                } else {
                    $id_user = 0;
                    $code = 403;
                    $message = "vous n'avez pas l'autorisation d'utiliser cette application";
                }
            } else {
                $id_user = 0;
                $code = 403;
                $message = "vous n'avez pas l'autorisation d'utiliser cette application";
            }
        } else {
            $id_user = 0;
            $code = 403;
            $message = "Utilisateur non connecté";
        }
        $user_connected = [
            "id_user" => $id_user,
            "code" => $code,
            "message" => $message,
        ];
        $response = new JsonResponse($user_connected);
        $response->headers->set('Access-Control-Allow-Headers', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');

        return $response;
    }

    /**
     * @Route("/validation/service", name="validation_service", methods={"GET", "POST"})
     */
    public function ValidationService(Request $request, PapiersRepository $papiersRepository, AnomaliesRepository $anomaliesRepository, ControlesRepository $controlesRepository, UserRepository $userRepository)//: Response
    {
        $controle_validated = [
            "id_controle" => 0,
            "code" => 404,
            "message" => "",
            "nombre_photo" => 0,
            "liste_photo" => "",
        ];

        $liste_photo = "face";

        $id_user = $request->query->get("user_id");
        $immatriculation = $request->query->get("immatriculation");
        $nom_chauffeur = $request->query->get("nom_chauffeur");
        $contact_chauffeur = $request->query->get("contact_chauffeur");
        $feuille_de_controle = $request->query->get("feuille_de_controle");
        $proprietaire = $request->query->get("proprietaire");
        $contact_proprietaire = $request->query->get("contact_proprietaire");
        $lieu_de_controle = $request->query->get("lieu_de_controle");
        $anomalies = $request->query->get("anomalies");
        $papiers = $request->query->get("papiers");
        $date_recuperation = $request->query->get("date_recuperation");
        $date_fin_recuperation = $request->query->get("date_fin_recuperation");
        $mise_en_fourriere = $request->query->get("mise_en_fourriere");
        
        $controle = new Controles();

        $user = $userRepository->findOneBy(["id" => $id_user]);
        //var_dump($anomalies);
        $controle->setImmatriculation($immatriculation);
        $controle->setVerificateur($user);
        $controle->setCentre($user->getCentre());
        $controle->setProprietaire($proprietaire);
        $controle->setTelephone($contact_proprietaire);
        $controle->setDateExpiration(new \DateTime($date_fin_recuperation));
        $controle->setCreatedAt(new \DateTime());
        $controle->setTimeCreatedAt(new \DateTime());
        $controle->setAjouteur($user);
        $liste_anomalies = explode(',', $anomalies);
        foreach($liste_anomalies as $num_anm){
            $anm = $anomaliesRepository->findOneBy(["id" => $num_anm]);
            if($anm != null){
                $liste_photo .= ",".$anm->getCodeAnomalie();
                $controle->addAnomaliesCollection($anm);
            }
        }
        $liste_papiers = explode(',', $papiers);
        foreach($liste_papiers as $num_pap){
            $pap = $papiersRepository->findOneBy(["id" => $num_pap]);
            if($pap != null){
                $controle->addPapiersCollection($pap);
            }
        }
        $controle->setMiseEnFourriere($mise_en_fourriere);
        $controle->setDateDebut(new \DateTime($date_recuperation));
        $controle->setNomChauffeur($nom_chauffeur);
        $controle->setContactChauffeur($contact_chauffeur);
        $controle->setFeuilleDeControle($feuille_de_controle);
        $controle->setLieuDeControle($lieu_de_controle);

        $controle->setPapiersRetirers($liste_papiers > 0 ? true : false);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($controle);
        $entityManager->flush();

        $controle_validated = [
            "id_controle" => $controle->getId(),
            "code" => 200,
            "message" => "",
            "nombre_photo" => count($liste_anomalies),
            "liste_photo" => $liste_photo,
        ];
        $response = new JsonResponse($controle_validated);
        $response->headers->set('Access-Control-Allow-Headers', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');

        return $response;
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/upload_photo", name="upload_photo", methods={"GET","POST"})
     */
    public function uploadPhoto(Request $request, ControlesRepository $controlesRepository)//: Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        /* $file = $request->query->get('photo');
        $controle_id = $request->query->get('controle_id');
        $photo_name = $request->query->get('photo_name'); */
        //$file = $request->files->get('photo');
        $file = $request->files->get('file');
        $controle_id = $request->request->get('controle_id');
        $photo_name = $request->request->get('photo_name');
        if($photo_name == null){
            $file = $request->files->get('photo');
            $controle_id = $request->query->get('controle_id');
            $photo_name = $request->query->get('photo_name');
        }
        $controle = $controlesRepository->findOneBy(["id" => $controle_id]);
        $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
        if (!file_exists($this->getParameter('photo')) && !is_dir($this->getParameter('photo'))) {
            mkdir($this->getParameter('photo'), 0775, true);
        }
        $file->move(
            $this->getParameter('photo'),
            $fileName
        );
        //$photo_name = "teste_app";
        //$fileName = "teste_app";
        //$controle = $controlesRepository->findOneBy(["id" => 1]);
        /* $daty   = new \DateTime(); //this returns the current date time
        $results = $daty->format('Y-m-d-H-i-s');
        $krr    = explode('-', $results);
        $results = implode("", $krr); */

        $photo = new Photo();
        //$photo->setNomPhoto($file->getClientOriginalName());
        //$photo->setFileName($fileName);
        $photo->setNomPhoto($photo_name);
        $photo->setFileName($fileName);
        $photo->setControle($controle);
        $entityManager->persist($photo);
        $entityManager->flush();

        $response = new JsonResponse(['code' => 200]);
        $response->headers->set('Access-Control-Allow-Headers', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');

        return $response;
        //return new JsonResponse(['code' => 200]);
    }

    /**
     * @Route("/recuperation/info", name="recuperation_info", methods={"GET","POST"})
     */
    public function RecuperationInfoCRI(Request $request, ControlesRepository $ControlesRepository/* , HttpClientInterface $client */)//: Response
    {
        $information_vehicule = [
            "nom_chauffeur" => "",
            "contact_chauffeur" => "",
            "nom_proprietaire" => "",
            "contact_proprietaire" => "",
        ];
        $immatriculation = strtoupper($request->query->get('immatriculation'));
        $info = new Controles();
        $liste_info = $ControlesRepository->findInfo($immatriculation);
        if(count($liste_info) == 1){
            foreach($liste_info as $lst_i){
                $information_vehicule = [
                    "nom_chauffeur" => $lst_i->getNomChauffeur(),
                    "contact_chauffeur" => $lst_i->getContactChauffeur(),
                    "nom_proprietaire" => $lst_i->getProprietaire(),
                    "contact_proprietaire" => $lst_i->getTelephone(),
                ];
            }
        }
        else{
            $information_vehicule = json_decode(file_get_contents('https://dgsrmada.com:2055/ct/service/mobile/recherche/proprietaire?immatriculation='.$immatriculation));
            //return $response;
        }
        $response = new JsonResponse($information_vehicule);
        $response->headers->set('Access-Control-Allow-Headers', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');

        return $response;
    }

    /**
     * @Route("/recuperation/Info/contre", name="recuperation_info_contre", methods={"GET", "POST"})
     */
    public function RecuperationInfoContre(Request $request, ControlesRepository $ControlesRepository, PhotoRepository $photoRepository/* , HttpClientInterface $client */)//: Response
    {
        $information_vehicule = [
            "papier_retirer" => 0,
            "nom_chauffeur" => "",
            "contact_chauffeur" => "",
            "nom_proprietaire" => "",
            "contact_proprietaire" => "",
            "lieu_controle" => "",
            "numero_feuille" => "",
            "anomalie_constater" => "",
            "papier_retirer" => "",
            "date_controle" => "",
            "date_recuperation" => "",
            "date_limite" => "",
            "mise_en_fourriere" => "",
            "photo" => "",
            "verificateur" => "",
            "centre" => "",
        ];
        $immatriculation = strtoupper($request->query->get('immatriculation'));
        $info = new Controles();
        $liste_info = $ControlesRepository->findInfo($immatriculation);
        if(count($liste_info) == 1){
            foreach($liste_info as $lst_i){
                $photos = $photoRepository->findBy(["controle" => $lst_i]);
                $photos_liste = "";
                foreach($photos as $photo){
                    if($photos_liste != ""){
                        $photos_liste += "-";
                    }
                    $photos_liste .= $photo->getFileName();
                }
                $papiers = $lst_i->getPapiersCollection();
                $papiers_liste = "";
                foreach($papiers as $papier){
                    if($papiers_liste != ""){
                        $papiers_liste += "-";
                    }
                    $papiers_liste .= $papier->getPapier();
                }
                $anomalies = $lst_i->getAnomaliesCollections();
                $anomalies_liste = "";
                foreach($anomalies as $anomalie){
                    if($anomalies_liste != ""){
                        $anomalies_liste .= "-";
                    }
                    $anomalies_liste += $anomalie->getCodeAnomalie();
                }
                $information_vehicule = [
                    "papier_retirer" => $lst_i->getPapiersRetirers()?"Oui":"Non",
                    "nom_chauffeur" => $lst_i->getNomChauffeur(),
                    "contact_chauffeur" => $lst_i->getContactChauffeur(),
                    "nom_proprietaire" => $lst_i->getProprietaire(),
                    "contact_proprietaire" => $lst_i->getTelephone(),
                    "lieu_controle" => $lst_i->getLieuDeControle(),
                    "numero_feuille" => $lst_i->getFeuilleDeControle(),
                    "anomalie_constater" => $anomalies_liste,
                    "papier_retirer" => $papiers_liste,
                    "date_controle" => $lst_i->getCreatedAt()->format("d/m/Y"),
                    "date_recuperation" => $lst_i->getDateDebut()->format("d/m/Y"),
                    "date_limite" => $lst_i->getDateExpiration()->format("d/m/Y"),
                    "mise_en_fourriere" => $lst_i->getMiseEnFourriere()?"Oui":"Non",
                    "photo" => $photos_liste,
                    "verificateur" => $lst_i->getVerificateur()->getNom().' '.$lst_i->getVerificateur()->getPrenom(),
                    "centre" => $lst_i->getCentre()->getCentre(),
                ];
            }
        }
        /* else{
            $information_vehicule = json_decode(file_get_contents('https://dgsrmada.com:2055/ct/service/mobile/recherche/proprietaire?immatriculation='.$immatriculation));
            //return $response;
        } */
        $response = new JsonResponse($information_vehicule);
        $response->headers->set('Access-Control-Allow-Headers', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');

        return $response;
    }
    

    /**
     * @Route("/regulatisation/contre", name="regularisation_contre", methods={"GET","POST"})
     */
    public function RegularisationContre(Request $request, UserRepository $userRepository, ControlesRepository $ControlesRepository/* , HttpClientInterface $client */)//: Response
    {
        $id_user = $request->query->get("user_id");
        $controle_id = $request->query->get("controle_id");
        
        $user = $userRepository->findOneBy(["id" => $id_user]);
        $controle = $ControlesRepository->findOneBy(["id" => $controle_id]);

        $controle->setVerificateurContre($user);
        $controle->setRetireur($user);
        $controle->setDateRetrait(new \DateTime());
        $controle->getHeureRetrait(new \DateTime());
        $controle->setPapiersRetirers(1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($controle);
        $entityManager->flush();

        $controle_regularisation = [
            "id_controle" => $controle_id,
            "code" => 200,
            "message" => "controle régulariser avec succès",
        ];
        $response = new JsonResponse($controle_regularisation);
        $response->headers->set('Access-Control-Allow-Headers', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');

        return $response;
    }
}
