<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Role;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RoleFormType;

class RoleController extends AbstractController
{
    /**
     * @Route("/role", name="role")
     */
    public function role(Request $request)
    {
        $role = new Role();
        $role->setRole('role');

        $form = $this->createForm(RoleFormType::class, $role);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profession = $form->getData();
            return $this->redirectToRoute('role');
        }

        return $this->render('role/role.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
