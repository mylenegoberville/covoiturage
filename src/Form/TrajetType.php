<?php

namespace App\Form;

use App\Entity\Trajet;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('voiture',EntityType::class,array( 
                'class' => Voiture::class, 
                  'choice_label'=>'nom', 
                'label' =>'choisir une voiture', 
                'multiple' => false, 
                'required' => true
            ))
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
            ->add('voiture',EntityType::class,array( 
                'class' => Voiture::class, 
                  'choice_label'=>'nom', 
                'label' =>'choisir une voiture', 
                'multiple' => false, 
                'required' => true
            ))
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
