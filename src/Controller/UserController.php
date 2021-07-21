<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Videolist;
use App\Form\User2Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * Получение и передача данных в таблицу "Пользователи"
     * @Route("adminPanel/user", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('admin_panel/user/index.html.twig', [
            'users' => $users,
            'user' => $user,
        ]);
    }

    /**
     * Создание нового пользователя
     * @Route("adminPanel/user/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $user = new User();
        $form = $this->createForm(User2Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin_panel/user/_form.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Показ опеределенного пользователя
     * @Route("adminPanel/user/show/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin_panel/user/_delete_form.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Изменение определенного пользователя
     * @Route("adminPanel/user/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(User2Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('admin_panel/user/_form.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Удаление определенного пользователя
     * @Route("adminPanel/user/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user, Videolist $vd): Response
    {
        $id = $user->getId();
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $vd = $this->getDoctrine()->getRepository(Videolist::class)->findBy(['user' => $id]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
