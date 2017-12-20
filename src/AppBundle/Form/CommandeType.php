<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateTimeType::class)
            ->add('duree', ChoiceType::class, [
                'choices'=> ['Demi-journée' =>'halfDay', 'Journée entière' =>'fullDay'],
                'multiple' => false,
                'expanded' => true
            ])
            ->add('visiteurs', CollectionType::class, [
                'entry_type' => VisitorType::class,
                 'allow_add' => true,
                 'allow_delete' => true
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_commande_type';
    }
}
