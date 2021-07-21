<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategoryController extends AbstractController //Контроллер проекта
{
    /**
     * Получение и занесение всех данных о категориях в таблицу
     * @Route("adminPanel/category", name="category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $user = $this->getUser();
        return $this->render('admin_panel/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'user' => $user,
        ]);

    }

    /**
     * Создание новой категории
     * @Route("adminPanel/category/new", name="category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('admin_panel/category/_form.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * Удаление определенной выбранной категории
     * @Route("adminPanel/category/show/{id}", name="category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        $user = $this->getUser();
        return $this->render('admin_panel/category/_delete_form.html.twig', [
            'category' => $category,
            'user' => $user,
        ]);
    }

    /**
     * Изменение выбранной категории
     * @Route("adminPanel/category/{id}/edit", name="category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Category $category): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index', [
                'id' => $category->getId(),
                'user' => $user,
            ]);
        }

        return $this->render('admin_panel/category/_form.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * Удаление выбранной категории
     * @Route("adminPanel/category/{id}", name="category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_index');
    }
}
