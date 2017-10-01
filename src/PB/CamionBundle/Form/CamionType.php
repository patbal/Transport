<?php

namespace PB\CamionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CamionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateEnlevement', DateType::class, array(
                'widget' => 'single_text',
                'label' => 'Date d\'enlèvement'))
            ->add('nbJoursExploit', IntegerType::class, array('label'=>'Nombre de jour(s) d\'exploitation'))
            ->add('dateRetour', DateType::class, array(
                'widget' => 'single_text',
                'label' => 'Date de retour'))
            ->add('operation', TextType::class, ['label' => 'Opération', 'required' => false])
            ->add('remarque', TextareaType::class, array(
                'label' => 'Remarque',
                'required' => false))
            ->add('avecHayon', CheckboxType::class, array('required' => false))
            ->add('effectue', CheckboxType::class, array('label' => 'Effectuée', 'required' => false))
            ->add('annule', CheckboxType::class, array('label' => 'Annulée', 'required' => false))
            ->add('factureRecue', CheckboxType::class, array('required' => false, 'label' => 'Facture reçue'))
            ->add('loueur', EntityType::class, array(
                'class'        => 'PBCamionBundle:Loueur',
                'choice_label' => 'nom',
                'multiple'     => false,
                'expanded'     => false))
            /*->add('contactFrom', EntityType::class, array(
                'class'        => 'PBTransportBundle:Contact',
                'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u')
                    ->orderBy('u.nom', 'ASC');},
                'multiple'     => false,
                'expanded'     => false,
                'label' => 'Véhicule demandé par : '))*/
            ->add('vehicule', EntityType::class, array(
                'class'         => 'PBCamionBundle:TypeVehicule',
                'choice_label'  => 'vehicule',
                'multiple'      => false,
                'expanded'      => false
                ))
            ->add('save',            submitType::class);

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PB\CamionBundle\Entity\Camion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pb_camionbundle_camion';
    }


}
