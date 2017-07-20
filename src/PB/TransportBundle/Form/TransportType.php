<?php

namespace PB\TransportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use OC\PlatformBundle\Form\TransporteurType;
use OC\PlatformBundle\Form\AdresseType;
use OC\PlatformBundle\Form\ContactType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TransportType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('datecreation',   DateTimeType::class, array('format' => 'dd-MMMM-yyyy'))
        ->add('dateenlevement', DateTimeType::class)
        ->add('datelivraison',  DateTimeType::class)
        ->add('remarque',       TextareaType::class)
        ->add('operation',      TextType::class)
        ->add('effectue',       CheckboxType::class, array('required' => false))
        ->add('annule',         CheckboxType::class, array('required' => false))
        ->add('transporteur',   EntityType::class, array(
            'class'        => 'PBTransportBundle:Transporteur',
            'choice_label' => 'nom',
            'multiple'     => false,
            'expanded'     => true))
        ->add('adresseFrom',    EntityType::class, array(
            'class'        => 'PBTransportBundle:Adresse',
            'choice_label' => 'societe',
            'multiple'     => false,
            'expanded'     => true))
        ->add('contactFrom',    EntityType::class, array(
            'class'        => 'PBTransportBundle:Contact',
            'choice_label' => 'nom',
            'multiple'     => false,
            'expanded'     => true))
        ->add('adresseTo',    EntityType::class, array(
            'class'        => 'PBTransportBundle:Adresse',
            'choice_label' => 'societe',
            'multiple'     => false,
            'expanded'     => true))
        ->add('contactTo',    EntityType::class, array(
            'class'        => 'PBTransportBundle:Contact',
            'choice_label' => 'nom',
            'multiple'     => false,
            'expanded'     => true))
        ->add('save'            submitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PB\TransportBundle\Entity\Transport'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pb_transportbundle_transport';
    }


}
