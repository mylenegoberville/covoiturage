<?php

namespace App\Utils;

use App\Entity\Payement as EntityPayement;
use App\Entity\Trajet;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Stripe\StripeClient;

class Payement {

    public function __construct(
        private string $stripeApiSecret,
        private EntityManagerInterface $entityManager
    ){

    }

    public function createAccount(User $user) {

        $stripe = new StripeClient($this->stripeApiSecret);
        $customer = $stripe->customers->create([
            'description' => $user->getPrenom() . ' ' . $user->getNom(),
            'email' => $user->getEmail(),
        ]);
        $user->setStripekey($customer['id']);
        $this->entityManager->flush();
        return $customer;
    }

    public function getAccount(User $user){
        if (!$user->getStripekey()){
            return $this->createAccount($user);
        }
        $stripe = new StripeClient($this->stripeApiSecret);
        $customer = $stripe->customers->retrieve(
            $user->getStripekey()
        );
        return $customer;
    }

    public function createPayment(User $user, Trajet $trajet){
        $stripe = new StripeClient($this->stripeApiSecret);
        $stripePayement = $stripe->paymentIntents->create([
            'customer' => $user->getStripekey(),
            'amount' => $trajet->getPrix()*100,
            'currency' => 'eur',
            'payment_method_types' => ['card'],
        ]);
        $payement = new EntityPayement();
        $payement->setStripeId($stripePayement['id'])->setUser($user);
        $this->entityManager->persist($payement);
        $this->entityManager->flush();
        return $payement;
    }

    public function retrievePayment(EntityPayement $payement){
        $stripe = new StripeClient($this->stripeApiSecret);
        return $stripe->paymentIntents->retrieve($payement->getStripeId());
        
    }

}
