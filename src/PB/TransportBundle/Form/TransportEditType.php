<?php

namespace PB\TransportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use PB\TransportBundle\Form\TransporteurType;
use PB\TransportBundle\Form\AdresseType;
use PB\TransportBundle\Form\ContactType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
// use PB\TransportBundle\Entity\TypeTransport;


class TransportEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('operation',      TextType::class, ['label' => 'Opération', 'required' => false])
        
        ->add('transporteur',   EntityType::class, array(
            'class'        => 'PBTransportBundle:Transporteur',
            'choice_label' => 'nom',
            'multiple'     => false,
            'expanded'     => false))
        
        ->add('typeTr',   EntityType::class, array(
            'class'        => 'PBTransportBundle:TypeTransport',
            'choice_label' => 'type',
            'multiple'     => false,
            'expanded'     => true))

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
            'multiple'     => false,
            'expanded'     => false,
            'label' => 'Contact Destinataire'))
        
        ->add('remarque',       TextareaType::class, array(
            'label' => 'Remarque',
            'required' => false))
        
        ->add('effectue',       CheckboxType::class, array('required' => false))
        
        ->add('annule',         CheckboxType::class, array('required' => false))

        ->add('dateenlevement', DateType::class, array(
            'widget' => 'single_text',
            'label' => 'Date d\'enlèvement'))
        ->add('datelivraison', DateType::class, array(
            'widget' => 'single_text',
            'label' => 'Date de livraison'))

        ->add('factureRecue',   CheckboxType::class, array('required'=>false))

        ->add('save',            submitType::class);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA, // 1er argument : L'évènement qui nous intéresse : ici, PRE_SET_DATA
            function(FormEvent $event) // 2e argument : La fonction à exécuter lorsquel'évènement est déclenche
            {
                $transport = $event->getData(); // On récupère notre objet sous-jacent
                if ($transport->getTypeTr() === null || !$transport) 
                {
                  return; // On sort de la fonction sans rien faire lorsque $advert vaut null
                }

                $type = $transport->getTypeTr()->getType();

                if($type == 'Course')
                {
                    
                    $event->getForm()->add('vehicule',   EntityType::class, array(
                        'class'        => 'PBTransportBundle:TypeVehicule',
                        'choice_label' => 'typevehicule',
                        'multiple'     => false,
                        'expanded'     => false));
                    $event->getForm()->add('heureEnlevement', TimeType::class, [
                        'label' => 'Heure d\'enlèvement (hh:mm)']);
                    $event->getForm()->add('heureLivraison', TimeType::class, [
                        'label' => 'Heure de livraison (hh:mm)', 
                        'widget' => 'choice']);
                }
                
                if($type == 'Transport')
                {
                    $event->getForm()->add('nbpalettes',     TextType::class, ['required'=>false, 'label' => 'Nbre de palettes / Colis / Flight']);
                    $event->getForm()->add('mplancher',      IntegerType::class, ['required'=>false, 'label' => 'Mètre(s) de plancher']);
                }
                
            });




    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PB\transportBundle\Entity\transport'
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
