<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/InfoCompte.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/ModificationUser', name: 'modifiUser')]
    public function modifierUser(User $user ,Request $request, EntityManagerInterface $entityManager): Response


    {   
        
        $formmodifuser = $this->createForm(UserType::class, $user, array('modifier'=>true));

        $formmodifuser->handleRequest($request);

        if($formmodifuser->isSubmitted() && $formmodifuser->isValid())
        {
               $entityManager->persist($user);
               $entityManager->flush();
               $this->addFlash('success',"Vos informations ont bien été modifé");
               return $this->render('user/infoCompte.html.twig');

            }
        
        return $this->render('user/infoCompte.html.twig', [
            'user'=>$user,
            'formmodifuser' => $formmodifuser->createView(), 
            //'admin'=>true,  
        ]);
    }
}
