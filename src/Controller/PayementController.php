<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\Payement;

class PayementController extends AbstractController
{
    #[Route(path: '/payement', name: 'app_payement')]
    public function payement(Payement $payement): Response
    {
        $payement->createAccount($this->getUser());
        
    }

}
