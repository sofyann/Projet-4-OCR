<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Coordonnee extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [

            ])
            ->add('nom', TextType::class, [

            ])
            ->add('mail', EmailType::class, [

            ])
            ->add('num' )
            ->add('adresse', TextType::class, [

            ])
            ->add('codePostal', NumberType::class, [

            ])
            ->add('ville')
            ->add('pays')
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
