<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class VisitorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez indiquer votre prénom.(entre 2 et 50 caractère)'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 50
                    ])
                ]
            ])
            ->add('nom', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez indiquer votre nom.(entre 2 et 50 caractère)'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 50
                    ])
                ]
            ])
            ->add('pays', CountryType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
                'placeholder' => 'Pays',
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez choisir votre pays.'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 50
                    ])
                ]
            ])
            ->add('date_de_naissance', DateType::class, [
                'widget' => 'single_text',
                'label' => false,
                'attr' => [
                    'placeholder' => 'Date de naissance',
                    'class' => 'form-control date_de_naissance'
                ],
                'constraints' => [
                    new Date(),
                    new NotNull([
                        'message' => 'Vous devez indiquer votre date de naissance.'
                    ])
                ]
            ])
            ->add('tarif_reduit', CheckboxType::class,[
                'label' => 'Tarif réduit',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_visitor_type';
    }
}
