<?php

namespace App\Form;

use App\Entity\Controles;
use App\Entity\Anomalies;
use App\Entity\Papiers;
use App\Entity\User;
use App\Entity\Utilisations;
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
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class ControlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Immatriculation', TextType::class, [
                'label' => 'Immatriculation du véhicule',
                'required'   => true,
                'attr' => [
                    'class' => 'col-8',
                ],
            ])
            ->add('usages', EntityType::class, [
                'class' => Utilisations::class,
                'label' => 'Usage effectif',
                'required'   => true,
                'attr' => [
                    'class' => 'col-8',
                    'data-live-search' => true,
                ],
            ])
            ->add('Enregistrement', TextType::class, [
                'label' => 'N° d\'enregistrement à la visite',
                'required'   => true,
                'attr' => [
                    'class' => 'col-8'
                ],
            ])
            ->add('verificateur', EntityType::class, [
                'class' => User::class,
                'label' => 'Nom du vérificateur',
                'required'   => true,
                'attr' => [
                    'class' => 'col-8',
                    'data-live-search' => true,
                ],
            ])
            //->add('centre', null, ['label' => 'CENSERO ayant effectué la dernière visite'])
            ->add('proprietaire', TextType::class, [
                'label' => 'Nom du prorpiétaire',
                'required'   => true,
                'attr' => [
                    'class' => 'col-8'
                ],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse du propriétaire',
                'required'   => true,
                'attr' => [
                    'class' => 'col-8'
                ],
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone du propriétaire',
                'required'   => true,
                'attr' => [
                    'class' => 'col-8'
                ],
            ])
            //->add('anomalies', TextareaType::class, ['label' => 'Anomalies constatées'])
            ->add('date_expiration', DateType::class, [
                'label' => 'Date expiration de visite technique',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datepicker col-8'
                ],
                'data' => new \DateTime('now'),
                'required'   => true,
            ])
            //->add('papiers_retirers', CheckboxType::class, ['label' => 'Papiers retiré'])
            ->add('anomalies_collections', EntityType::class, [
                'class' => Anomalies::class,
                //'remote_route' => 'anomalies_liste',
                'label' => 'Anomalies',
                'required'   => true,
                'attr' => [
                    'class' => 'multi col-8',
                    'multiple' => true, 
                    'data-live-search' => true,
                    'data-select' => true,
                    'required' => true,
                ],
            ])
            ->add('papiers_collection', EntityType::class, [
                'class' => Papiers::class,
                'label' => 'Papiers',
                'attr' => [
                    'class' => 'chosen-select-width chzn col-8', 
                    'multiple' => true, 
                    'remote_route' => '',
                    'data-live-search' => true,
                    'data-select' => true,
                    'required' => true,
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
