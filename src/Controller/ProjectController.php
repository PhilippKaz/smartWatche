<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\Project1Type;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProjectController extends AbstractController //Контроллер проекта
{
    /**
     * Маршрут получения данных о проектах в таблицу "Проекты"
     * @Route("adminPanel/project", name="project_index", methods={"GET"})
     */
    public function index(ProjectRepository $projectRepository): Response
    {
        $user = $this->getUser();
        return $this->render('admin_panel/project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
            'user' => $user,
        ]);
    }

    /**
     * Создание нового проекта
     * @Route("adminPanel/project/new", name="project_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $project = new Project();
        $form = $this->createForm(Project1Type::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('project_index');
        }

        return $this->render('admin_panel/project/_form.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * Просмотр определенного проекта
     * @Route("adminPanel/project/show/{id}", name="project_show", methods={"GET"})
     */
    public function show(Project $project): Response
    {
        $user = $this->getUser();
        return $this->render('admin_panel/project/_delete_form.html.twig', [
            'project' => $project,
            'user' => $user,
        ]);
    }

    /**
     * Изменение выбранного проекта
     * @Route("adminPanel/project/{id}/edit", name="project_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Project $project): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(Project1Type::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_index', [
                'id' => $project->getId(),
            ]);
        }

        return $this->render('admin_panel/project/_form.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * Удаление определенного проекта
     * @Route("adminPanel/project/{id}", name="project_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Project $project): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();
        }
        return $this->redirectToRoute('project_index');
    }
}
