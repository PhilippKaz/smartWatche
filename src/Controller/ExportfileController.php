<?php

namespace App\Controller;

use App\Entity\Videolist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;

class ExportfileController extends Controller
{
    /**
     * Экспорт добавленых видео пользователя
     * @Route("/userPanel/exportfile", name="exportFromUserPanel")
     */
    public function exportFromUserPanel()
    {
        $userName = $this->getUser();

        if ($userName != null)
        {
            $userID = $this->getUser()->id;
            $video = $this->getDoctrine()->getRepository(Videolist::class)->findBy(['user' => $userID]);
            $vidlist = $this->getDoctrine()->getRepository(Videolist::class);
            $vidlist->exportFromUserPanel($userID);
            return $this->redirectToRoute("user_panel");
        }

    }

    /**
     * Экспорт данных всех таблиц
     * @Route("/adminPanel/exportfilefromAdmin", name="exportFromAdminPanel")
     */
    public function exportFromAdminPanel()
    {
        $userName = $this->getUser();

        if ($userName != null)
        {
            $userID = $this->getUser()->id;
            $video = $this->getDoctrine()->getRepository(Videolist::class)->findBy(['user' => $userID]);
            $vidlist = $this->getDoctrine()->getRepository(Videolist::class);
            $vidlist->exportFromAdminPanel();

            return $this->redirectToRoute("admin_panel");
        }

    }
}
