<?php

namespace App\Form;

use App\Entity\PortfolioProject;
use App\Entity\Tags;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => ' ',
                'attr' => array(
                    'placeholder' => 'Nom du projet'
                )])
            ->add('presentation', null, [
                'label' => ' ',
                'attr' => array(
                    'placeholder' => 'Présentation du projet'
                )])
            ->add('description', CKEditorType::class, [
                'label' => 'Description du projet'
                ])
            ->add('tags', EntityType::class, [
                'label' => 'Tags',
                'class' => Tags::class,
                'multiple' => true,
                'choice_label' => 'name',
                'by_reference' => false,
                'attr' => [
                    'class' => 'select-tags'
                ]
                ])
            ->add('github', null, [
                'label' => ' ',
                'attr' => array(
                    'placeholder' => 'Lien du Github'
                )])
            ->add('link', null, [
                'label' => ' ',
                'attr' => array(
                    'placeholder' => 'Lien du projet'
                )])
            ->add('screenshotImg', FileType::class, [
                'label' => 'Ajouter un screenshot',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci de téleverser une image au bon format.',
                    ])
                ],
            ])
            ->add('screenshot2Img', FileType::class, [
                'label' => 'Ajouter un deuxième screenshot',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci de téleverser une image au bon format.',
                    ])
                ],
            ])
            ->add('screenshot3Img', FileType::class, [
                'label' => 'Ajouter un troisème screenshot',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci de téleverser une image au bon format.',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PortfolioProject::class,
        ]);
    }
}
