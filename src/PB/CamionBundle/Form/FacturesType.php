<?php

namespace PB\CamionBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FacturesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroFacture', TextType::class, ['label'=>'N° Facture'])
            ->add('montantFacture', MoneyType::class, ['label'=>'Montant €HT', 'currency'=>'EUR'])
            ->add('dateFacture',DateType::class, ['widget' => 'single_text', 'label' => 'Date Facture'])
            ->add('loueur', EntityType::class, array(
                'label'=>'Loueur',
                'class'=>'PB\CamionBundle\Entity\Loueur',
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
            'data_class' => 'PB\CamionBundle\Entity\Factures'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pb_camionbundle_factures';
    }


}
