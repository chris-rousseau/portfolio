<?php

namespace App\Controller\Blog;

use App\Entity\BlogComment;
use App\Entity\BlogPost;
use App\Form\CommentType;
use App\Repository\BlogCommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog/", name="blog_post_")
 */
class PostController extends AbstractController
{
    /**
     * @Route("{slug}", name="single")
     */
    public function single(Request $request, PaginatorInterface $paginator, BlogPost $blogPost, BlogCommentRepository $blogCommentRepository): Response
    {
        $allComments = $blogCommentRepository->findBy([
            'post' => $blogPost->getId()
        ], [
            'created_at' => 'desc'
        ]);

        $pagination = $paginator->paginate(
            $allComments,
            $request->query->getInt('page', 1),
            5
        );

        $comment = new BlogComment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($blogPost);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre commentaire à bien été ajouté ! Merci :)'
            );

            return $this->redirectToRoute('blog_post_single', [
                'slug' => $blogPost->getSlug()
            ]);
        }

        return $this->render('blog/post/index.html.twig', [
            'post' => $blogPost,
            'allComments' => $pagination,
            'form' => $form->createView(),
        ]);
    }
}
