<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\Video1Type;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class VideoController extends AbstractController //Контроолер видео
{
    /**
     *  Получение и передача данных о пользователях в таблицу "Видео"
     * @Route("adminPanel/video", name="video_index", methods={"GET"})
     */
    public function index(VideoRepository $videoRepository): Response
    {
        $user = $this->getUser();
        return $this->render('admin_panel/video/index.html.twig', [
            'videos' => $videoRepository->findAll(),
            'user' => $user,
        ]);
    }

    /**
     * Создание нового видео
     * @Route("adminPanel/video/new", name="video_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $video = new Video();
        $form = $this->createForm(Video1Type::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('video_index');
        }

        return $this->render('admin_panel/video/_form.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * Отображение определенного видео
     * @Route("adminPanel/video/show/{id}", name="video_show", methods={"GET"})
     */
    public function show(Video $video): Response
    {
        $user = $this->getUser();
        return $this->render('admin_panel/video/_delete_form.html.twig', [
            'video' => $video,
            'user' => $user,
        ]);
    }

    /**
     * Изменение определенного видео
     * @Route("adminPanel/video/{id}/edit", name="video_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Video $video): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(Video1Type::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('video_index', [
                'id' => $video->getId(),
            ]);
        }

        return $this->render('admin_panel/video/_form.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * Удаление определенного видео
     * @Route("adminPanel/video/{id}", name="video_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Video $video): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$video->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($video);
            $entityManager->flush();
        }

        return $this->redirectToRoute('video_index');
    }
}
