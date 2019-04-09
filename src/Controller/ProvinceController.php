<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Province;

class ProvinceController extends AbstractController
{
    /**
     * @Route("/province", name="province")
     */
    public function province()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $province = new Province();
        $province->setProvince("ANTANANARIVO");

        $entityManager->persist($province);

        $entityManager->flush();

        return $this->render('province/index.html.twig', [
            'controller_name' => 'ProvinceController',
        ]);
    }
}
