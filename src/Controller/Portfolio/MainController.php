<?php

namespace App\Controller\Portfolio;

use App\Entity\PortfolioProject;
use App\Repository\PortfolioProjectRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("", name="site_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/credits", name="credits", methods={"GET"})
     */
    public function credits(): Response
    {
        return $this->render('site/main/credits.html.twig');
    }

    /**
     * @Route("/portfolio/{slug}", name="details", methods={"GET"})
     */
    public function details(PortfolioProject $portfolioProject): Response
    {

        return $this->render('site/main/project_details.html.twig', [
            'project' => $portfolioProject,
        ]);
    }

    /**
     * @Route("", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('site/main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/portfolio", name="projects", methods={"GET"})
     */
    public function projects(PortfolioProjectRepository $portfolioProjectRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $allProjects = $portfolioProjectRepository->findBy([], [
            'created_at' => 'desc'
        ]);

        $pagination = $paginator->paginate(
            $allProjects,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('site/main/projects.html.twig', [
            'allProjects' => $pagination,
        ]);
    }
}
