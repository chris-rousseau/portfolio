<?php

namespace App\Controller\Admin;

use App\Entity\BlogCategory;
use App\Form\CategoryType;
use App\Repository\BlogCategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin/category", name="admin_category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function index(BlogCategoryRepository $blogCategoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $allCategories = $blogCategoryRepository->findAll();

        $pagination = $paginator->paginate(
            $allCategories,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/category/list.html.twig', [
            'allCategories' => $pagination,
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request, SluggerInterface $slugger): Response
    {
        $category = new BlogCategory();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($category->getName());
            $category->setSlug(strtolower($slug));

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash(
                'success',
                'La catégorie à bien été ajoutée !'
            );

            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-{id}", name="edit", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function edit(Request $request, BlogCategory $blogCategory, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(CategoryType::class, $blogCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($blogCategory->getName());
            $blogCategory->setSlug(strtolower($slug));

            $em = $this->getDoctrine()->getManager();
            $em->persist($blogCategory);
            $em->flush();

            $this->addFlash(
                'success',
                'La catégorie à bien été éditée !'
            );

            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render('admin/category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete-{id}", name="delete", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function delete(BlogCategory $blogCategory): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($blogCategory);
        $em->flush();

        $this->addFlash(
            'danger',
            'La catégorie à bien été suprimée !'
        );

        return $this->redirectToRoute('admin_category_list');
    }
}
