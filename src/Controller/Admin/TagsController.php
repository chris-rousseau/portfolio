<?php

namespace App\Controller\Admin;

use App\Entity\Tags;
use App\Repository\TagsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagsController extends AbstractController
{
    /**
     * @Route("/tags/add/ajax/{label}", name="admin_tags_add", methods={"POST"})
     */
    public function addTags(string $label, EntityManagerInterface $em): Response
    {
        $tag = new Tags();
        $tag->setName(trim(strip_tags($label)));

        $em->persist($tag);
        $em->flush();

        $id = $tag->getId();

        return new JsonResponse(['id' => $id]);
    }

    /**
     * @Route("admin/tags/list", name="admin_tags_list", methods={"GET"})
     */
    public function list(TagsRepository $tagsRepository): Response
    {
        $allTags = $tagsRepository->findAll();

        return $this->render('admin/tags/list.html.twig', [
            'allTags' => $allTags,
        ]);
    }

    /**
     * @Route("admin/tags/delete-{id}", name="admin_tags_delete", requirements={"id"="\d+"})
     */
    public function delete(Tags $tags): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($tags);
        $em->flush();

        $this->addFlash(
            'danger',
            'Le tag à bien été supprimé'
        );

        return $this->redirectToRoute('admin_tags_list');
    }
}
