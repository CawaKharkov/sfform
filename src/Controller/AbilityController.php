<?php

namespace App\Controller;

use App\Entity\Ability;
use App\Form\AbilityArrayType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AbilityController extends AbstractController
{
    /**
     * @Route("/ability", name="ability")
     */
    public function index(\Symfony\Component\HttpFoundation\Request $request)
    {

        $abilities = $this->getDoctrine()->getRepository(Ability::class)->findAll();


        $form = $this->createForm(AbilityArrayType::class, ['abilities' => $abilities]);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->getData()['abilities'] as $ability){
                $this->getDoctrine()->getManager()->persist($ability);

            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('ability');
        }



        return $this->render('ability/index.html.twig', [
            'controller_name' => 'AbilityController',
            'form' => $form->createView()
        ]);
    }
}
