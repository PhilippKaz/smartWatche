<?php

namespace App\Controller;

use App\Entity\Videolist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Entity\Video;

class DeleteController extends Controller
{
    /**
     * Удаление выбранного видео из списка "Добавленные видео"
     * @Route("/delete/{id}", name="delete")
     */
    public function index($id)
    {
        $uri  = $_SERVER['REQUEST_URI'];
        $qPos = strpos($uri, '?');

        if ($qPos === strlen($uri) - 1) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . substr($uri, 0, $qPos));
            exit;
        }

        $user = $this->getUser();
        $usid = $user->id;
        $id_video = $this->getDoctrine()->getRepository(Video::class)->find($id);
        $id_videolist = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['video' => $id_video]);
        $vl = new Videolist();
        $this->getDoctrine()->getManager()->remove($id_videolist);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute("main");
    }
}
