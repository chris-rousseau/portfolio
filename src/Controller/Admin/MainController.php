<?php

namespace App\Controller\Admin;

use App\Repository\BlogCategoryRepository;
use App\Repository\BlogCommentRepository;
use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("", name="dashboard", methods={"GET"})
     */
    public function dashboard(BlogPostRepository $blogPostRepository, BlogCommentRepository $blogCommentRepository, BlogCategoryRepository $blogCategoryRepository): Response
    {
        $countAllPosts = count($blogPostRepository->findAll());
        $countAllComments = count($blogCommentRepository->findAll());
        $countAllCategories = count($blogCategoryRepository->findAll());

        return $this->render('admin/dashboard/index.html.twig', [
            'countAllPosts' => $countAllPosts,
            'countAllComments' => $countAllComments,
            'countAllCategories' => $countAllCategories,
        ]);
    }
}
