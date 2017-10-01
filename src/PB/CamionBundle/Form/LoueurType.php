<?php

namespace PB\CamionBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoueurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('label'=>'Nom de la société'))
            ->add('adresse', TextType::class, array('label'=>'Adresse', 'required'=>false))
            ->add('adresse2', TextType::class, array('label'=>'Complément d\'adresse', 'required'=>false))
            ->add('cp', TextType::class, array('label'=>'Code Postal', 'required'=>false))
            ->add('ville', TextType::class, array('label'=>'Ville', 'required'=>false))
            ->add('tel', TextType::class, array('label'=>'N° de téléphone', 'required'=>false))
            ->add('email', TextType::class, array('label'=>'Email'))
            ->add('save', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PB\CamionBundle\Entity\Loueur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pb_camionbundle_loueur';
    }


}
