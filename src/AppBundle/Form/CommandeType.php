<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotNull;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                    'constraints' => [
                        new NotNull([
                            'message' => 'Vous devez choisir une date.'
                        ]),
                        new Date([
                            'message' => 'La date est invalide'
                        ])

                    ]
            ]
            )
            ->add('duree', ChoiceType::class, [
                'choices'=> ['Demi-journée' =>'halfDay', 'Journée entière' =>'fullDay'],
                'multiple' => false,
                'expanded' => true,
                'label' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez choisir le type de billet.'
                    ])
                ]
            ])
            ->add('visitors', CollectionType::class, [
                'entry_type' => VisitorType::class,
                 'allow_add' => true,
                 'allow_delete' => true,
                'label' => false,
                'constraints' => [
                    new NotNull()

                ]
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
