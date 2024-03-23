<?php

namespace App\Controller\Admin;

use App\Entity\BlogComment;
use App\Repository\BlogCommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/comments", name="admin_comment_")
 */
class CommentController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $em
    )
    {
    }

    /**
     * @Route("/delete-{id}", name="delete", requirements={"id"="\d+"})
     */
    public function delete(BlogComment $blogComment): Response
    {
        $this->em->remove($blogComment);
        $this->em->flush();

        $this->addFlash(
            'danger',
            'Le commentaire à bien été supprimé !'
        );

        return $this->redirectToRoute('admin_comment_list');
    }

    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function list(BlogCommentRepository $blogCommentRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $allComments = $blogCommentRepository->findBy([], [
            'created_at' => 'desc'
        ]);

        $pagination = $paginator->paginate(
            $allComments,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/comment/list.html.twig', [
            'allComments' => $pagination,
        ]);
    }
}
