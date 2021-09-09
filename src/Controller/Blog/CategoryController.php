<?php

namespace App\Controller\Blog;

use App\Entity\BlogCategory;
use App\Repository\BlogPostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog/categorie/", name="blog_category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("{slug}", name="list", methods={"GET"})
     */
    public function list(BlogPostRepository $blogPostRepository, BlogCategory $blogCategory, PaginatorInterface $paginator, Request $request): Response
    {
        $allPostsInCategory = $blogPostRepository->findBy([
            'category' => $blogCategory->getId(),
        ], [
            'created_at' => 'desc'
        ]);

        $pagination = $paginator->paginate(
            $allPostsInCategory,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('blog/category/index.html.twig', [
            'allPosts' => $pagination,
            'category' => $blogCategory
        ]);
    }
}
