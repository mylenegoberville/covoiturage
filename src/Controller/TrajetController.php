<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Form\TrajetType;
use App\Repository\TrajetRepository;
use App\Utils\Payement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrajetController extends AbstractController
{
    #[Route('/trajet', name: 'app_trajet')]
    public function index(TrajetRepository $trajetRepository, Request $request): Response
    {
        $trajets = $trajetRepository->findAll();
        return $this->render('trajet/AllTrajet.html.twig', [
            'trajets' => $trajets,
        ]);
    }

    #[Route('/trajetByUser', name: 'trajetByUser')]
    public function trajetByUser(TrajetRepository $trajetRepository,  Request $request): Response
    {
        
        $trajets = $trajetRepository->findBy(
            ['createdBy' => $this->getUser()]
        );
        return $this->render('trajet/TrajetsByUser.html.twig', [
            'trajets' => $trajets,
        ]);
    }


    #[Route('/AfficherTrajet/{id}', name: 'afficherTrajet')]
    public function afficherTrajet(Trajet $trajet ): Response
    {         
        return $this->render('trajet/AffichageTrajet.html.twig', [
          
            "trajet"=> $trajet,
            
        ]);
    }

    #[Route('/Addtrajet', name: 'addtrajet')]
    public function addTrajet(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trajet = new Trajet();
        $formTrajet = $this->createForm(TrajetType::class,$trajet, array('ajouter'=>true));

        $formTrajet->handleRequest($request);
        if ($formTrajet->isSubmitted() && $formTrajet->isValid()) {
            

            //Nous allons dans cette exemple sauvgarder nos données 
            $trajet->setCreatedBy($this->getUser());
            $entityManager->persist($trajet);
            $entityManager->flush();
            $this->addFlash('success',"le trajet a bien été enregisté");
            return $this->redirectToRoute('trajetByUser');
        }
        return $this->render('trajet/addTrajet.html.twig', [
            'formTrajet' => $formTrajet->createView(),
        ]);
    }

    #[Route('/ModificationTrajet/{id}', name: 'modifiTrajet')]
    public function modifiertrajet(Trajet $trajet ,Request $request, EntityManagerInterface $entityManager): Response


    {   
        
        $formmodiftrajet = $this->createForm(TrajetType::class, $trajet, array('modifier'=>true));

        $formmodiftrajet->handleRequest($request);

        if($formmodiftrajet->isSubmitted() && $formmodiftrajet->isValid())
        {
               $entityManager->persist($trajet);
               $entityManager->flush();
               $this->addFlash('success',"le trajet a bien été modifié");
               return $this->redirectToRoute('trajetByUser');

            }
        
        return $this->render('trajet/ModifierTrajet.html.twig', [
            'trajet'=>$trajet,
            'formmodiftrajet' => $formmodiftrajet->createView(),  
        ]);
    }

    #[Route('/suppvoiture/{id}', name: 'suppvoiture')]
    public function supprimervoiture(Trajet $trajet ,Request $request, EntityManagerInterface $entityManager): Response


    {  
        if($this->isCsrfTokenValid("SUP".$trajet->getId(), $request->get("_token")) ){
            $entityManager->remove($trajet);
            $entityManager->flush();
            $this->addFlash('success',"le trajet a bien été supprimé");
            return $this->redirectToRoute('app_trajet');
        }

     }

     #[Route('/reserver/trajet/{id}', name: 'reserverTrajet')]
     public function reserverTrajet(Trajet $trajet, Payement $payementUtils)
     {
        $payementUtils->getAccount($this->getUser());
        $payementUtils->createPayment($this->getUser(),$trajet);
        return $this->redirectToRoute('app_payements'); 
     }

}
