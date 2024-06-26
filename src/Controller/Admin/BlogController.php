<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use App\Form\PostType;
use App\Repository\BlogCommentRepository;
use App\Repository\BlogPostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("admin/blog", name="admin_blog_")
 */
class BlogController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em
    )
    {
    }

    /**
     * @Route("/add", name="add", methods={"GET","POST"})
     */
    public function add(Request $request, SluggerInterface $slugger, UserRepository $userRepository): Response
    {
        $post = new BlogPost();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($post->getTitle());
            $post->setSlug(strtolower($slug));

            $user = $userRepository->findOneBy([
                'id' => 1
            ]);
            $post->setUser($user);

            $this->em->persist($post);
            $this->em->flush();

            $this->addFlash(
                'success',
                'L\'article à bien été ajouté !'
            );

            return $this->redirectToRoute('admin_blog_list');
        }
        

        return $this->render('admin/blog/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete-{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete(BlogPost $blogPost): Response
    {
        $this->em->remove($blogPost);
        $this->em->flush();

        $this->addFlash(
            'danger',
            'L\'article bien été supprimé !'
        );

        return $this->redirectToRoute('admin_blog_list');
    }

    /**
     * @Route("/edit-{id}", name="edit", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function edit(BlogPost $blogPost, Request $request, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($blogPost->getTitle());
            $blogPost->setSlug(strtolower($slug));

            $this->em->persist($blogPost);
            $this->em->flush();

            $this->addFlash(
                'success',
                'L\'article a été modifié avec succes !'
            );

            return $this->redirectToRoute('admin_blog_list');
        }

        return $this->render('admin/blog/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $blogPost
        ]);
    }

    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function list(BlogPostRepository $blogPostRepository, BlogCommentRepository $blogCommentRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $allPosts = $blogPostRepository->findBy([], [
            'created_at' => 'desc'
        ]);

        $pagination = $paginator->paginate(
            $allPosts,
            $request->query->getInt('page', 1),
            10
        );

        $allComments = $blogCommentRepository->findAll();

        return $this->render('admin/blog/list.html.twig', [
            'allPosts' => $pagination,
            'allComments' => $allComments,
        ]);
    }
}
