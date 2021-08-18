<?php

namespace App\Controller\Blog;

use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog/", name="blog_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(BlogPostRepository $blogPostRepository): Response
    {
        $allPosts = $blogPostRepository->findAll();
        // dd($allPosts);

        return $this->render('blog/main/index.html.twig', [
            'allPosts' => $allPosts,
        ]);
    }
}
