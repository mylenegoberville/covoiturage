<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Form\TrajetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrajetController extends AbstractController
{
    #[Route('/trajet', name: 'app_trajet')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trajet = new Trajet();
        $formTrajet = $this->createForm(TrajetType::class, $trajet);

        $formTrajet->handleRequest($request);
        if ($formTrajet->isSubmitted() && $formTrajet->isValid()) {
            // $form->getData() contient les valeurs soumises
            $trajet = $formTrajet->getData();

            //Nous allons dans cette exemple sauvgarder nos données 
            $entityManager->persist($trajet);
            $entityManager->flush();
            $this->addFlash('success',"le trajet a bien été enregisté");
            return $this->render('trajet/TrajetsByUser.html.twig');
        }
        return $this->render('trajet/addTrajet.html.twig', [
            'formTrajet' => $formTrajet->createView(),
        ]);
    }

    #[Route('/ModificationTrajet', name: 'modifiTrajet')]
    public function modifierchantier(Trajet $trajet ,Request $request, EntityManagerInterface $entityManager): Response


    {   
        
        $formmodiftrajet = $this->createForm(TrajetType::class, $trajet, array('modifier'=>true));

        $formmodiftrajet->handleRequest($request);

        if($formmodiftrajet->isSubmitted() && $formmodiftrajet->isValid())
        {
               $entityManager->persist($trajet);
               $entityManager->flush();
               $this->addFlash('success',"le trajet a bien été modifié");
               return $this->render('trajet/TrajetsByUser.html.twig');

            }
        
        return $this->render('trajet/ModifierTrajet.html.twig', [
            'trajet'=>$trajet,
            'formmodiftrajet' => $formmodiftrajet->createView(), 
            //'admin'=>true,  
        ]);
    }


}
