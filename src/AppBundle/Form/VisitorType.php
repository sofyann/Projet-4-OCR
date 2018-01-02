<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                ]
            ])
            ->add('nom', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control'
                ]
            ])
            ->add('pays', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Pays',
                    'class' => 'form-control'
                ]
            ])
            ->add('date_de_naissance', DateType::class, [
                'widget' => 'single_text',
                'label' => false,
                'attr' => [
                    'placeholder' => 'Date de naissance',
                    'class' => 'form-control'

                ]
            ])
            ->add('tarif_reduit', ChoiceType::class,[
                'choices'=> ['Tarif réduit' =>'tarifReduit'],
                'multiple' => true,
                'expanded' => true,
                'label' => false,
                'required' => false,
                'placeholder' => false,

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
