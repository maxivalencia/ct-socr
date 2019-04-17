<?php

namespace App\Form;

use App\Entity\Controles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ControlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Immatriculation')
            ->add('usages')
            ->add('Enregistrement')
            ->add('verificateur')
            ->add('centre')
            ->add('proprietaire')
            ->add('adresse')
            ->add('telephone')
            ->add('anomalies')
            ->add('date_expiration')
            ->add('papiers_retirers')
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
