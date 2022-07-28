<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\Payement;

class PayementController extends AbstractController
{
    #[Route(path: '/payement', name: 'app_payements')]
    public function payement(Payement $payementUtils): Response
    {
        $payements=[];
        foreach ($this->getUser()->getPayements() as $userPayement)
        {
            $payements[]=$payementUtils->retrievePayment($userPayement);
            
        }
        return $this->render('user/transactions.html.twig',['payements'=>$payements]);
        
    }

}
