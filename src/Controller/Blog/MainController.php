<?php

namespace App\Controller\Blog;

use App\Repository\BlogPostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog", name="blog_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(BlogPostRepository $blogPostRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $allPosts = $blogPostRepository->findBy([], [
            'created_at' => 'desc'
        ]);

        $pagination = $paginator->paginate(
            $allPosts,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('blog/main/index.html.twig', [
            'allPosts' => $allPosts,
            'pagination_article' => $pagination,
        ]);
    }
}
