<?php

namespace PB\TransportBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FacturesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numerofacture',  TextType::class, ['label'=>'N° Facture'])
            ->add('montantfacture',     MoneyType::class, ['label'=>'Montant €HT', 'currency'=>'EUR'])
            ->add('datefacture',        DateType::class, ['widget' => 'single_text',
            'label' => 'Date Facture'])
            ->add('transporteur',       EntityType::class, array(
                'label'=>'Transporteur',
                'class'=>'PB\TransportBundle\Entity\Transporteur',
                'choice_label' => 'nom',
                'multiple'     => false,
                'expanded'     => false))
            ->add('Save',                           SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PB\TransportBundle\Entity\Factures'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pb_transportbundle_factures';
    }


}
