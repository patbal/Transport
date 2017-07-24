<?php

namespace PB\TransportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use PB\TransportBundle\Form\TransporteurType;
use PB\TransportBundle\Form\AdresseType;
use PB\TransportBundle\Form\ContactType;
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
        // ->add('datecreation',   DateTimeType::class, array('format' => 'dd-MMMM-yyyy'))
        ->add('dateenlevement', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'enlèvement'
            ])
        ->add('datelivraison', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de livraison'
            ])
        // ->add('datelivraison',  DateTimeType::class)
        ->add('operation',      TextType::class, ['label' => 'Opération'])
        ->add('effectue',       CheckboxType::class, array('required' => false))
        ->add('annule',         CheckboxType::class, array('required' => false))
        ->add('transporteur',   EntityType::class, array(
            'class'        => 'PBTransportBundle:Transporteur',
            'choice_label' => 'nom',
            'multiple'     => false,
            'expanded'     => false))
        ->add('adresseFrom',    EntityType::class, array(
            'class'        => 'PBTransportBundle:Adresse',
            'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u')
            ->orderBy('u.societe', 'ASC');},
            'choice_label' => 'societe',
            'multiple'     => false,
            'expanded'     => false,
            'label' => 'Adresse Enlèvement'))
        ->add('contactFrom',    EntityType::class, array(
            'class'        => 'PBTransportBundle:Contact',
            'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u')
            ->orderBy('u.nom', 'ASC');},
            'choice_label' => 'nom',
            'multiple'     => false,
            'expanded'     => false,
            'label' => 'Contact Enlèvement'))
        ->add('adresseTo',    EntityType::class, array(
            'class'        => 'PBTransportBundle:Adresse',
            'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u')
            ->orderBy('u.societe', 'ASC');},
            'choice_label' => 'societe',
            'multiple'     => false,
            'expanded'     => false,
            'label' => 'Adresse Destinataire'))
        ->add('contactTo',    EntityType::class, array(
            'class'        => 'PBTransportBundle:Contact',
            'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u')
            ->orderBy('u.nom', 'ASC');},
            'choice_label' => 'nom',
            'multiple'     => false,
            'expanded'     => false,
            'label' => 'Contact Destinataire'))
        ->add('remarque',       TextareaType::class, array(
            'label' => 'Remarque',
            'required' => 'false'))
        ->add('effectue',       CheckboxType::class, array('required' => false))
        ->add('annule',         CheckboxType::class, array('required' => false))
        ->add('save',            submitType::class);


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
