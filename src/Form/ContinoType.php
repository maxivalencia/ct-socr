<?php

namespace App\Form;

use App\Entity\Controles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContinoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Immatriculation')
            ->add('Enregistrement')
            ->add('proprietaire')
            ->add('adresse')
            ->add('telephone')
            //->add('anomalies')
            //->add('papiers')
            ->add('date_expiration')
            //->add('papiers_retirers')
            //->add('CreatedAt')
            //->add('date_retrait')
            //->add('heure_retrait')
            ->add('usages')
            ->add('verificateur')
            //->add('centre')
            //->add('ajouteur')
            //->add('retireur')
            ->add('anomalies_collections')
            ->add('papiers_collection')
            //->add('anom')
            //->add('pap')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Controles::class,
        ]);
    }
}
