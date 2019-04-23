<?php

namespace App\Form;

use App\Entity\Controles;
use App\Entity\Anomalies;
use App\Entity\Papiers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\ButtonType;

class ControlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Immatriculation', TextType::class, [
                'label' => 'Immatriculation du véhicule',
                'attr' => ['class' => 'col-8'],
                ])
            ->add('usages', null, [
                'label' => 'Usage effectif',
                'attr' => ['class' => 'col-8'],
                ])
            ->add('Enregistrement', TextType::class, [
                'label' => 'N° d\'enregistrement à la visite',
                'attr' => ['class' => 'col-8'],
                ])
            ->add('verificateur', null, [
                'label' => 'Nom du vérificateur',
                'attr' => ['class' => 'col-8'],
                ])
            //->add('centre', null, ['label' => 'CENSERO ayant effectué la dernière visite'])
            ->add('proprietaire', TextType::class, [
                'label' => 'Nom du prorpiétaire',
                'attr' => ['class' => 'col-8'],
                ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse du propriétaire',
                'attr' => ['class' => 'col-8'],
                ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone du propriétaire',
                'attr' => ['class' => 'col-8'],
                ])
            //->add('anomalies', TextareaType::class, ['label' => 'Anomalies constatées'])
            ->add('date_expiration', DateType::class, [
                'label' => 'Date expiration de visite technique',
                'widget' => 'single_text',
                //'input' => 'datetime_immutable',
                'attr' => ['class' => 'js-datepicker col-8'],
                'data' => new \DateTime('now'),
                ])
            //->add('papiers_retirers', CheckboxType::class, ['label' => 'Papiers retiré'])
            ->add('anomalies_collections', EntityType::class, [
                'class' => Anomalies::class,
                'label' => 'Anomalies', 
                'attr' => [
                    'class' => 'multiselect col-8', 
                    'multiple' => true, 
                    'data-live-search' => true,
                    'data-select' => true,
                ],
            ])
            ->add('papiers_collection', EntityType::class, [
                'class' => Papiers::class,
                'label' => 'Papiers',
                'attr' => [
                    'class' => 'multiselect col-8', 
                    'multiple' => true, 
                    'data-live-search' => true,
                    'data-select' => true,
                ],
            ])
            //->add('CreatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Controles::class,
        ]);
    }
}
