<?php

namespace PB\TransportBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransporteurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',            TextType::class, array('label'=>'Société'))
            ->add('adresseRue',     TextType::class, array('label'=>'Adresse'))
            ->add('adresseRue2',    TextType::class, array('required' => false, 'label'=>"Complément d'adresse"))
            ->add('codepostal',     NumberType::class, array('label'=>'Code Postal'))
            ->add('ville',          TextType::class, array('label'=>'Ville'))
            ->add('phone',          TextType::class, array('required' => false, 'label'=>'N° de téléphone'))
            ->add('email',          TextType::class, array('required' => false))
            ->add('contact',        EntityType::class, array(
                'class'        => 'PBTransportBundle:Contact',
                'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u')
                    ->orderBy('u.nom', 'ASC');},
                'multiple'     => 'true',
                'expanded'     => 'true',
                'label' => 'Contact(s)'))
            ->add('save',           submitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PB\TransportBundle\Entity\Transporteur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pb_transportbundle_transporteur';
    }


}
