<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotNull;

class CoordonneeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez indiquer votre prénom.'
                    ])
                ]

            ])
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez indiquer votre nom.'
                    ])
                ]
            ])
            ->add('mail', EmailType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez indiquer votre adresse mail.'
                    ]),
                    new Email([
                        'message' => 'Votre adresse mail est invalide.'
                    ])
                ]
            ])
            ->add('num', NumberType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez indiquer votre numéro de téléphone.'
                    ])
                ]
            ])
            ->add('adresse', TextType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez choisir le type de billet.'
                    ])
                ]
            ])
            ->add('codePostal', NumberType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez indiquer votre adresse.'
                    ])
                ]
            ])
            ->add('ville', TextType::class, [
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez indiquer votre ville.'
                    ])
                ]
            ])
            ->add('pays', CountryType::class,[
                'placeholder' => 'Pays',
                'constraints' => [
                    new NotNull([
                        'message' => 'Vous devez choisir votre pays.'
                    ]),
                    new Country([
                        'message' => 'Le pays indiquer est invalide.'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_coordonnee';
    }
}
