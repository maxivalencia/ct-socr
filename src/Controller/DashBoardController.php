<?php

namespace App\Controller;

use App\Entity\Controles;
use App\Entity\Anomalies;
use App\Entity\Papiers;
use App\Repository\ControlesRepository;
use App\Repository\AnomaliesRepository;
use App\Repository\PapiersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashBoardController extends AbstractController
{
    /**
     * @Route("/dash/board", name="dash_board")
     */
    public function index(ControlesRepository $controlesRepository)
    {
        /* 
            Ny zavatra ampidirina eto dia : 
            - ny courbe de controle journalière mandritra ny iray volana,
            - controle total ao anatin'ny iray andro,
            - ny anomalie tena hita matetika,
            - isan'ny papier récupérer tao anatin'ny iray andro,
            - isan'ny papier niverina amin'ny tompony,
            - isan'ny papier mbola mijanona ao amin'ny controle inopiné, total an'izy rehetra,
            - nombre de mise en fourièrre,

         */

        // courbe de contrôle journalière 
        $controle_sur_trente_jours = $controlesRepository->countByDayLast30Days();

        // controle total ao anatin'ny iray andro
        $total_today = $controlesRepository->countForToday();

        // anomalie le plus souvent constaté
        // mbola ketrehana raha mety, atao amin'ny entity anomalie (repository) no ametrahana azy

        // isan'ny papier récupérer tao anatin'ny iray andro

        // isan'ny papier récupérer fitambaran'ny rehetra hatramin'izay

        // isan'ny papier miverina amin'ny tompony androany
        $papier_recuperer_today = $controlesRepository->countPapierRecupererForToday();

        // isan'ny papier miverina amin'ny tompony fitambarany rehetra
        $papier_recuperer = $controlesRepository->countPapierRecuperer();

        // nombre de mise en fourièrre total,
        $mise_en_fourierre_today = $controlesRepository->countMiseEnFourierreForToday();

        // nombre de mise en fourièrre de la journée
        $mise_en_fourierre = $controlesRepository->countMiseEnFourierre();

        return $this->render('dash_board/index.html.twig', [
            'controller_name' => 'DashBoardController',
        ]);
    }
}
