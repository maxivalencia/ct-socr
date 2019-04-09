<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Province;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProvinceFormType;

class ProvinceController extends AbstractController
{
    /**
     * @Route("/province", name="province")
     */
    public function province(Request $request)
    {
        $province = new Province();
        $province->setProvince('province');

        $form = $this->createForm(ProvinceFormType::class, $province);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $province = $form->getData();
            return $this->redirectToRoute('province');
        }

        return $this->render('province/province.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
