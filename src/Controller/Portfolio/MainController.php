<?php

namespace App\Controller\Portfolio;

use App\Repository\PortfolioProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("", name="site_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(): Response
    {
        return $this->render('site/main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/portfolio", name="projects")
     */
    public function projects(PortfolioProjectRepository $portfolioProjectRepository): Response
    {
        $allProjects = $portfolioProjectRepository->findBy([], [
            'created_at' => 'desc'
        ]);

        return $this->render('site/main/projects.html.twig', [
            'allProjects' => $allProjects,
        ]);
    }

    /**
     * @Route("/portfolio/{slug}", name="details")
     */
    public function details(): Response
    {
        return $this->render('site/main/project_details.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
