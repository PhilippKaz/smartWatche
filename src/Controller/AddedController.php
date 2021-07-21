<?php

namespace App\Controller;

use App\Entity\Videolist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Entity\Video;

class AddedController extends Controller
{
    /**
     * Добавление выбранного видео в список "Добавленные видео"
     * @Route("/added/{id}", name="added")
     */
    public function index($id, Request $request)
    {
        //Удаление знака вопроса в конце адресной строки
        $uri  = $_SERVER['REQUEST_URI'];
        $qPos = strpos($uri, '?');

        if ($qPos === strlen($uri) - 1) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . substr($uri, 0, $qPos));
            exit;
        }

        $user = $this->getUser();
        $usid = $user->id;
        $id_user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $usid]);
        $id_video = $this->getDoctrine()->getRepository(Video::class)->findOneBy(['id' => $id]);
        $vl = new Videolist();
        //Добавление данных в список добавленных видео
        $vl->setTitle($id_video->title);
        $vl->setCover($id_video->cover);
        $vl->setCreated($id_video->created);
        $vl->setDescription($id_video->description);
        $vl->setAdded(date('H:i:s Y-m-d'));
        $vl->setVideo($id_video);
        $vl->setUser($id_user);
        $this->getDoctrine()->getManager()->persist($vl);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute("main");
    }
}
