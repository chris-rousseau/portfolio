<?php

namespace App\Controller\Admin;

use App\Entity\PortfolioProject;
use App\Form\ProjectType;
use App\Repository\PortfolioProjectRepository;
use App\Service\UploadImage;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin/projects", name="admin_project_")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function list(PortfolioProjectRepository $portfolioProjectRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $allProjects = $portfolioProjectRepository->findBy([], [
            'created_at' => 'desc'
        ]);

        $pagination = $paginator->paginate(
            $allProjects,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/project/list.html.twig', [
            'allProjects' => $pagination,
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET","POST"})
     */
    public function add(Request $request, SluggerInterface $slugger, UploadImage $upload): Response
    {
        $project = new PortfolioProject();

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $screenshot = $upload->uploadImg($form, 'screenshotImg');

            if ($screenshot !== null) {
                $project->setScreenshot($screenshot);
            }

            $slug = $slugger->slug($project->getName());
            $project->setSlug(strtolower($slug));

            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            $this->addFlash(
                'success',
                'Le projet à bien été ajouté !'
            );

            return $this->redirectToRoute('admin_project_list');
        }

        return $this->render('admin/project/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-{id}", name="edit", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function edit(PortfolioProject $portfolioProject, Request $request, SluggerInterface $slugger, UploadImage $upload): Response
    {
        $form = $this->createForm(ProjectType::class, $portfolioProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $screenshot = $upload->uploadImg($form, 'screenshotImg');

            if ($screenshot !== null) {
                $portfolioProject->setScreenshot($screenshot);
            }

            $slug = $slugger->slug($portfolioProject->getName());
            $portfolioProject->setSlug(strtolower($slug));

            $em = $this->getDoctrine()->getManager();
            $em->persist($portfolioProject);
            $em->flush();

            $this->addFlash(
                'success',
                'Le projet à bien été édité !'
            );

            return $this->redirectToRoute('admin_project_list');
        }

        return $this->render('admin/project/edit.html.twig', [
            'form' => $form->createView(),
            'project' => $portfolioProject
        ]);
    }

    /**
     * @Route("/delete-{id}", name="delete", requirements={"id"="\d+"}, methods={"GET","POST"})
     */
    public function delete(PortfolioProject $portfolioProject): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($portfolioProject);
        $em->flush();

        $this->addFlash(
            'danger',
            'Le projet à bien été supprimé !'
        );

        return $this->redirectToRoute('admin_project_list');
    }
}
