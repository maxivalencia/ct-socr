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
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @Route("/anomalies", name="liste_anomalie", methods={"GET"})
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
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/papiers", name="liste_papiers", methods={"GET"})
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
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

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
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}
