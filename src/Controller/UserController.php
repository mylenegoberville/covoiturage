<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('user/InfoCompte.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/ListUser', name: 'listuser')]
    public function ListUser(UserRepository $UserRepository, Request $request): Response
    {
        $users = $UserRepository->findAll();
        return $this->render('user/ListeUser.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/AffichageUser/{id}', name: 'affichageUser')]
    public function afficheuser(User $user): Response
    {  
        return $this->render('user/FicheCompletUser.html.twig', [
            "user"=> $user
        ]);
    }

    #[Route('/ModificationUser/{id}', name: 'modifiUser')]
    public function modifierUser(User $user ,Request $request, EntityManagerInterface $entityManager): Response


    {   
        
        $formmodifuser = $this->createForm(RegistrationFormType::class, $user, array('ajouter'=>true));

        $formmodifuser->handleRequest($request);

        if($formmodifuser->isSubmitted() && $formmodifuser->isValid())
        {
               $entityManager->persist($user);
               $entityManager->flush();
               $this->addFlash('success',"Vos informations ont bien été modifé");
               return $this->redirectToRoute('app_user');

            }
        
        return $this->render('user/ModifierUser.html.twig', [
            'user'=>$user,
            'formmodifuser' => $formmodifuser->createView(), 
        ]);
    }

    #[Route('/suppUser/{id}', name: 'suppUSer')]
    public function supprimeruser(User $user ,Request $request, EntityManagerInterface $entityManager): Response


    {  
        if($this->isCsrfTokenValid("SUP".$user->getId(), $request->get("_token")) ){
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success',"l'utilisateur a bien été supprimé");
            return $this->redirectToRoute('listuser');
        }

     }
}
