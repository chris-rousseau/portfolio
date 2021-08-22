<?php

namespace App\Form;

use App\Entity\BlogCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => ' ',
                'attr' => array(
                    'placeholder' => 'Nom'
            )])
            ->add('description', null, [
                'label' => ' ',
                'attr' => array(
                    'placeholder' => 'Description'
            )])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BlogCategory::class,
        ]);
    }
}
