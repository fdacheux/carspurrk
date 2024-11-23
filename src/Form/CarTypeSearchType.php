<?php

namespace App\Form;

use App\Entity\CarSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CarTypeSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('minYear', IntegerType::class, [
                'required' => false,
                'label' => 'From year : ',
                ])
            ->add('maxYear', IntegerType::class, [
                'required' => false,
                'label' => 'To year : ',
                ])
            ->setMethod('GET')
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CarSearch::class,
        ]);
    }
}
