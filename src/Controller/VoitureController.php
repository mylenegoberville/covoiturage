<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoitureController extends AbstractController
{
    #[Route('/voiture', name: 'app_voiture')]
    public function index( Request $request): Response
    {
        return $this->render('voiture/affichageVoiture.html.twig', [
            'voiture' => $voiture,
            'admin'=>false,
        ]);
    }

    #[Route('/Addvoiture', name: 'addvoiture')]
    public function AjoutVoiture(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = new Voiture();
        $formVoiture = $this->createForm(VoitureType::class,$voiture, array('ajouter'=>true));

        $formVoiture->handleRequest($request);
        if ($formVoiture->isSubmitted() && $formVoiture->isValid()) {
            // $form->getData() contient les valeurs soumises
            $voiture = $formVoiture->getData();

            //Nous allons dans cette exemple sauvgarder nos données 
            $entityManager->persist($voiture);
            $entityManager->flush();
            $this->addFlash('success',"le véhicule a bien été enregisté");
            return $this->render('voiture/AffichageVoiture.html.twig');
        }
        return $this->render('voiture/addVoiture.html.twig', [
            'formVoiture' => $formVoiture->createView(),
        ]);
    }
}
