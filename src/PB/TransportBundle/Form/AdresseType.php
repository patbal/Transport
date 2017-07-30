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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AdresseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('societe',    TextType::class, ['label'=>'Société'])
            ->add('adresse1',   TextType::class, ['label'=>'Adresse'])
            ->add('adresse2',   TextType::class, array(
                'label'=>'Complément Adresse',
                'required'=>false))
            ->add('codepostal', TextType::class, ['label'=>'Code Postal'])
            ->add('ville',      TextType::class, ['label'=>'Ville'])
            ->add('contacts',   EntityType::class, array(
                'class'        => 'PBTransportBundle:Contact',
                'query_builder' => function (EntityRepository $er) {return $er->createQueryBuilder('u')
                ->orderBy('u.nom', 'ASC');},
                'multiple'     => 'true',
                'expanded'     => 'true',
                'label' => 'Contact(s)'))
            ->add('save',       submitType::class)
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PB\TransportBundle\Entity\Adresse'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pb_transportbundle_adresse';
    }


}
