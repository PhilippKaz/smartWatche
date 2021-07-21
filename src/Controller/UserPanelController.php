<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Videolist;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class UserPanelController extends Controller//Контроллер панели пользователя
{
    /**
     *  Переход на панель пользователя
     * @Route("/userPanel", name="user_panel")
     */
    public function index( Request $request, PaginatorInterface $paginator)
    {
        $userName = $this->getUser();

        if ($userName != null) {
            $userID = $this->getUser()->id;

                $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findBy(['user' => $userID]);
                $allVideo = $this->get('knp_paginator')->paginate
                (
                    $videoid,
                    $request->query->getInt('page', 1),
                    5
                );

                return $this->render('userpanel/index.html.twig', [
                    'user' => $userName,
                    'videolists' => $videoid,
                    'sq_vid' => $allVideo,
                ]);
            }
    }

    /**
     *  Переход на панель пользователя
     * @Route("/userpanel/delete/{id}", name="delete_videofromvideolist")
     */
    public function delete ($id, Request $request, PaginatorInterface $paginator)
    {
        $user = $this->getUser();

        $videolist = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['id' => $id]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($videolist);
        $entityManager->flush();

        return $this->redirectToRoute('user_panel');

    }
}
