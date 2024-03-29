<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($options['ajouter']== true)
        {
            $builder
            ->add('nom')
            ->add('marque')
            ->add('modele')
            ->add('couleur')
            ->add('immatriculation')
            ->add('distinction')
        ;
        }
        elseif($options['modifier']== true)
        { 
            $builder
            ->add('nom')
            ->add('marque')
            ->add('modele')
            ->add('couleur')
            ->add('immatriculation')
            ->add('distinction')
        ;
        }
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
            'ajouter'=>false,
            'modifier'=>false
        ]);
    }
}
