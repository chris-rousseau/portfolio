<?php

namespace App\Controller\Admin;

use App\Entity\Tags;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagsController extends AbstractController
{
    /**
     * @Route("/tags/add/ajax/{label}", name="tags_add", methods={"POST"})
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
}
