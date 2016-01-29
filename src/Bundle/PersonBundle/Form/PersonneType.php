<?php
namespace Framelab\Bundle\PersonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PersonneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('dateNaissance', DateType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
            ))
            ->add('email')
            ->add('tel')
            ->add('service')
            ->add('lieuTravail')
        ;
    }
}
