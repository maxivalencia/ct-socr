<?php

namespace App\Form;

use App\Entity\Controles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ControlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Immatriculation', TextType::class, ['label' => 'Immatriculation du véhicule'])
            ->add('usages', null, ['label' => 'Usage effectif'])
            ->add('Enregistrement', TextType::class, ['label' => 'N° d\'enregistrement à la visite'])
            ->add('verificateur', null, ['label' => 'Nom du vérificateur'])
            ->add('centre', null, ['label' => 'CENSERO ayant effectué la dernière visite'])
            ->add('proprietaire', TextType::class, ['label' => 'Nom du prorpiétaire'])
            ->add('adresse', TextType::class, ['label' => 'Adresse du propriétaire'])
            ->add('telephone', TextType::class, ['label' => 'Téléphone du propriétaire'])
            ->add('anomalies', TextareaType::class, ['label' => 'Anomalies constatées'])
            ->add('date_expiration', DateType::class, ['label' => 'Date expiration de visite technique'])
            ->add('papiers_retirers', CheckboxType::class, ['label' => 'Papiers retiré'])
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
