<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //type text classique
            ->add('name', TextType::class)
            // Potentiellement Text Area
            ->add('overview', TextareaType::class,[
                'label'=>'Synopsis',
                'required'=>false,
                ])
            // Choix multiple
            ->add('status', ChoiceType::class,['choices'=>[
                'Canceled'=> 'canceled',
                'Returning'=>'returning',
                'Ended' => 'ended'
            ]])

            ->add('vote')
            ->add('popularity')
            ->add('genres', ChoiceType::class,[
                'choices'=>[
                    //Gauche en visuel , droite en BDD
                    'Drama'=>'Drama',
                    'Comedy'=>'Comedy',
                    'Sci-Fi'=> 'Sci-Fi',
                    'Thriller'=>'Thriller',
                    'Family'=>'Family'

                ],
                'expanded' => true,
                'multiple' => true,
                'mapped'=>false// recuperation des informations manuel
                ])
            ->add('firstAirDate',DateType::class,[
                'html5'=>true,
                'widget'=> 'single_text'

        ])
            ->add('lastAirDate',DateType::class,[
                'html5'=>true,
                'widget'=> 'single_text'

            ])
            ->add('backdrop')
            ->add('poster')
            ->add('tmdbId')


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
            'required'=>false
        ]);
    }
}
