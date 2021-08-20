<?php

namespace App\Form;

use App\Entity\BlogCategory;
use App\Entity\BlogPost;
use App\Repository\BlogCategoryRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    private $blogCategoryRepository;

    public function __construct(BlogCategoryRepository $blogCategoryRepository)
    {
        $this->blogCategoryRepository = $blogCategoryRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categories = $this->blogCategoryRepository->findAll();

        $builder
            ->add('title', null, [
                'label' => ' ',
                'attr' => array(
                    'placeholder' => 'Titre de l\'article'
                )])
            ->add('category', ChoiceType::class, [
                'label' => ' ',
                'required' => true,
                'choices' => $categories,
                'choice_label' => function (?BlogCategory $blogCategory) {
                    return $blogCategory ? $blogCategory->getName() : '';
                },
            ])
            ->add('content', CKEditorType::class, [
                'label' => ' ',
                'attr' => array(
                    'placeholder' => 'Contenu de l\'article'
                )])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BlogPost::class,
        ]);
    }
}
