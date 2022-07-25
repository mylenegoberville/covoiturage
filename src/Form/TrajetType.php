<?php

namespace App\Form;

use App\Entity\Trajet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($options['ajouter']== true)
        {
            $builder
            ->add('depart')
            ->add('arrivee')
            ->add('date')
            ->add('heure')
            ->add('voiture')
            ->add('place')
            ->add('escale')
            ;
        }
        elseif($options['modifier']== true)
        { 
            $builder
            ->add('depart')
            ->add('arrivee')
            ->add('date')
            ->add('heure')
            ->add('voiture')
            ->add('place')
            ->add('escale')
            ;
        }
       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
            'ajouter'=>false,
            'modifier'=>false
        ]);
    }
}
