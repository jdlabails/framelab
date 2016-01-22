<?php

namespace Framelab\Bundle\TwitterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetweeterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('query')
            ->add('name')
            ->add('frequencyPerDay')
            ->add('actif')
            ->add('nbMonthKeeping');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'Framelab\Bundle\TwitterBundle\Entity\Retweeter']);
    }
}
