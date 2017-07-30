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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use PB\TransportBundle\Form\TransporteurType;
use PB\TransportBundle\Form\AdresseType;
use PB\TransportBundle\Form\ContactType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TransportBriefType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        // $builder->remove('dateenlevement');
        // $builder->remove('datelivraison');
        $builder->remove('vehicule');
        $builder->remove('nbpalettes');
        $builder->remove('mplancher');
        $builder->remove('contactFrom');
        $builder->remove('contactTo');
        $builder->remove('remarque');
        $builder->remove('effectue');
        $builder->remove('annule');

    }
    
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TransportType::class; 
    }


}
