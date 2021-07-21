<?php

namespace App\Controller;

use App\Entity\Videolist;
use App\Form\Videolist1Type;
use App\Repository\VideolistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideolistController extends AbstractController
{
    /**
     * Получение и передача данных в таблицу "Добавленные видео"
     * @Route("adminPanel/videolist", name="videolist_index", methods={"GET"})
     */
    public function index(VideolistRepository $videolistRepository): Response
    {
        $user = $this->getUser();
        return $this->render('admin_panel/videolist/index.html.twig', [
            'videolists' => $videolistRepository->findAll(),
            'user' => $user,
        ]);
    }

    /**
     * Добавление нового видео в список "Добавленное видео"
     * @Route("adminPanel/videolist/new", name="videolist_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $videolist = new Videolist();
        $form = $this->createForm(Videolist1Type::class, $videolist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($videolist);
            $entityManager->flush();

            return $this->redirectToRoute('videolist_index');
        }

        return $this->render('admin_panel/videolist/_form.html.twig', [
            'videolist' => $videolist,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * Отображение определенного добавленного видео
     * @Route("adminPanel/videolist/show/{id}", name="videolist_show", methods={"GET"})
     */
    public function show(Videolist $videolist): Response
    {
        $user = $this->getUser();
        return $this->render('admin_panel/videolist/_delete_form.html.twig', [
            'videolist' => $videolist,
            'user' => $user,
        ]);
    }

    /**
     * Изменение определенного добавленного видео
     * @Route("adminPanel/videolist/{id}/edit", name="videolist_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Videolist $videolist): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(Videolist1Type::class, $videolist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('videolist_index', [
                'id' => $videolist->getId(),
            ]);
        }

        return $this->render('admin_panel/videolist/_form.html.twig', [
            'videolist' => $videolist,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * Удаление определенного добавленного видео
     * @Route("adminPanel/videolist/{id}", name="videolist_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Videolist $videolist): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$videolist->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($videolist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('videolist_index');
    }
}
