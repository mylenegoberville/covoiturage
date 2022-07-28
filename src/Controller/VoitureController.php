<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoitureController extends AbstractController
{
    #[Route('/voiture', name: 'app_voiture')]
    public function index(VoitureRepository $VoitureRepository, Request $request): Response
    {
        $voitures = $VoitureRepository->findAll();
        return $this->render('voiture/affichageVoiture.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    #[Route('/voitureByUser', name: 'voitureByUser')]
    public function VoitureByUSer(VoitureRepository $VoitureRepository,  Request $request): Response
    {
        
        $voitures = $VoitureRepository->findBy(
            ['createdBy' => $this->getUser()]
        );
        return $this->render('user/FicheCompletUserVoiture.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    #[Route('/Addvoiture', name: 'addvoiture')]
    public function AjoutVoiture(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = new Voiture();
        $formVoiture = $this->createForm(VoitureType::class,$voiture, array('ajouter'=>true));

        $formVoiture->handleRequest($request);
        if ($formVoiture->isSubmitted() && $formVoiture->isValid()) {
            

            //Nous allons dans cette exemple sauvgarder nos données 
            $voiture->setCreatedBy($this->getUser());
            $entityManager->persist($voiture);
            $entityManager->flush();
            $this->addFlash('success',"le véhicule a bien été enregisté");
            return $this->redirectToRoute('app_voiture');
        }
        return $this->render('voiture/addVoiture.html.twig', [
            'formVoiture' => $formVoiture->createView(),
        ]);
    }

    #[Route('/modifvoiture/{id}', name: 'modifvoiture')]
    public function modifiervoiture(Voiture $voiture ,Request $request, EntityManagerInterface $entityManager): Response


    {   

        $formmodifvoiture = $this->createForm(VoitureType::class, $voiture, array('modifier'=>true));
        $formmodifvoiture->handleRequest($request);
        if($formmodifvoiture->isSubmitted() && $formmodifvoiture->isValid())
        {
 
           
               $entityManager->persist($voiture);
               $entityManager->flush();
               $this->addFlash('success',"la voiture a bien été modifié");
               return $this->redirectToRoute('app_voiture');
 
            
 
 
        }
 
        return $this->render('voiture/ModifierVoiture.html.twig', [
            'voiture'=>$voiture,
            'formmodifvoiture' => $formmodifvoiture->createView(),  
        ]);
    }


    #[Route('/suppvoiture/{id}', name: 'suppvoiture')]
    public function supprimervoiture(Voiture $voiture ,Request $request, EntityManagerInterface $entityManager): Response


    {  
        if($this->isCsrfTokenValid("SUP".$voiture->getId(), $request->get("_token")) ){
            $entityManager->remove($voiture);
            $entityManager->flush();
            $this->addFlash('success',"la voiture a bien été supprimé");
            return $this->redirectToRoute('app_voiture');
        }

     }
}
