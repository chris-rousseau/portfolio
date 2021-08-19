<?php

namespace App\Form;

use App\Entity\BlogComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Votre pseudo :'
            ])
            ->add('content', null, [
                'label' => 'Message :'
            ])
            ->add('save', SubmitType::class, ['label' => 'Envoyer votre message']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BlogComment::class,
        ]);
    }
}
