<?php

namespace App\Controller\Admin;

use App\Entity\BlogComment;
use App\Repository\BlogCommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/comments", name="admin_comment_")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function list(BlogCommentRepository $blogCommentRepository): Response
    {
        $allComments = $blogCommentRepository->findBy([], [
            'created_at' => 'desc'
        ]);

        return $this->render('admin/comment/list.html.twig', [
            'allComments' => $allComments,
        ]);
    }

    /**
     * @Route("/delete-{id}", name="delete", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function delete(BlogComment $blogComment): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($blogComment);
        $em->flush();

        $this->addFlash(
            'danger',
            'Le commentaire à bien été supprimé !'
        );

        return $this->redirectToRoute('admin_comment_list');
    }
}
