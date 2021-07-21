<?php

namespace App\Controller;

use App\Entity\User;

use App\Entity\Videolist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Category;
use App\Entity\Video;
use App\Entity\Genre;
use App\Entity\Project;

use Knp\Component\Pager\PaginatorInterface;

use App\Service\SearchServices;


class MainController extends Controller //Контроллер главного меню
{
    /**
     * Маршрут главной страницы
     * @Route("/", name="main")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
        $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findAll();
        $getCat = 1;
        $getVid = 1;
        $getProj = 0;

        $userName = $this->getUser();

        if ($userName != null) { //проверка на авторизацию пользователя
            $userID = $this->getUser()->id;

            $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findBy(['user' => $userID]);

            if ($videoid == null) { //проверка на пустое значение в списке "Добавленные видео"
                $userID = -1;
                $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
                $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findAll();
                $getCat = 1;
                $getVid = 1;
                $getProj = 0;
                $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['user' => $userID]);
                $allVideo = $this->get('knp_paginator')->paginate //модуль пагинации
                (
                    $mainVideos,
                    $request->query->getInt('page', 1),
                    32
                );

                return $this->render('main/video.html.twig', [
                    'sq_vid' => $allVideo,
                    'sq_data' => $mainCategories,
                    'getCat' => $getCat,
                    'user' => $userName,
                    'viid' => $videoid,
                    'prj' => $getProj,
                ]);
            } else {
                foreach ($videoid as $video) {
                    $vl[] = $video->getVideo()->getId();
                }

                $vidlist = $this->getDoctrine()->getRepository(Video::class);

                $sck = $vidlist->findVideo($vl);

                {
                    $allVideo = $this->get('knp_paginator')->paginate
                    (
                        $mainVideos,
                        $request->query->getInt('page', 1),
                        32
                    );

                    return $this->render('main/video.html.twig', [
                        'sq_vid' => $allVideo,
                        'sq_data' => $mainCategories,
                        'getCat' => $getCat,
                        'getVid' => $getVid,
                        'user' => $userName,
                        'viid' => $videoid,
                        'nonviid' => $sck,
                        'prj' => $getProj,
                    ]);
                }
            }

        }else
        {
            $userID = -1;
            $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
            $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findAll();
            $getCat = 1;
            $getVid = 1;
            $getProj = 0;
            $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['user' => $userID]);
            $allVideo = $this->get('knp_paginator')->paginate
            (
                $mainVideos,
                $request->query->getInt('page', 1),
                32
            );

            return $this->render('main/video.html.twig', [
                'sq_vid' => $allVideo,
                'sq_data' => $mainCategories,
                'getCat' => $getCat,
                'user' => $userName,
                'viid' => $videoid,
                'prj' => $getProj,
            ]);
        }
    }

    /**
     * Получение категории
     * @Route ("/category", name = "getCategory")
     */
    public function getCategory(Request $request, PaginatorInterface $paginator)
    {
        $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
        $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findAll();
        $getCat = 1;
        $getVid = 1;
        $userName = $this->getUser();
        if ($userName != null) {
            $userID = $this->getUser()->id;

            $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findBy(['user' => $userID]);

            if ($videoid == null) {
                $userID = -1;
                $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
                $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findAll();
                $getCat = 1;
                $getVid = 1;
                $getProj = 0;
                $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['user' => $userID]);
                $allVideo = $this->get('knp_paginator')->paginate
                (
                    $mainVideos,
                    $request->query->getInt('page', 1),
                    32
                );

                return $this->render('main/video.html.twig', [
                    'sq_vid' => $allVideo,
                    'sq_data' => $mainCategories,
                    'getCat' => $getCat,
                    'user' => $userName,
                    'viid' => $videoid,
                    'prj' => $getProj,
                ]);
            } else {
                foreach ($videoid as $video) {
                    $vl[] = $video->getVideo()->getId();
                }

                $vidlist = $this->getDoctrine()->getRepository(Video::class);
                $getProj = 0;
                $sck = $vidlist->findVideo($vl);

                {
                    $allVideo = $this->get('knp_paginator')->paginate
                    (
                        $mainVideos,
                        $request->query->getInt('page', 1),
                        32
                    );

                    return $this->render('main/video.html.twig', [
                        'sq_vid' => $allVideo,
                        'sq_data' => $mainCategories,
                        'getCat' => $getCat,
                        'getVid' => $getVid,
                        'user' => $userName,
                        'viid' => $videoid,
                        'nonviid' => $sck,
                        'prj' => $getProj,
                    ]);
                }
            }

        }else
        {
            $userID = -1;
            $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
            $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findAll();
            $getCat = 1;
            $getProj = 0;
            $getVid = 1;
            $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['user' => $userID]);
            $allVideo = $this->get('knp_paginator')->paginate
            (
                $mainVideos,
                $request->query->getInt('page', 1),
                32
            );

            return $this->render('main/video.html.twig', [
                'sq_vid' => $allVideo,
                'sq_data' => $mainCategories,
                'getCat' => $getCat,
                'user' => $userName,
                'viid' => $videoid,
                'prj' => $getProj,
            ]);
        }
    }

    /**
     * Выдача данных определенной категории
     * @Route ("/category/{id}", name = "showCategory")
     */
    public function showCategory($id, Request $request)
    {
        $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
        $getCat = 1;
        $getVid = 1;
        $getProj = 0;

        $userName = $this->getUser();

        if ($userName != null) {
            $userID = $this->getUser()->id;

            $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findBy(['user' => $userID]);

            if ($videoid == null) {
                $userID = -1;
                $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
                $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findBy(['category' => $id]);
                $getCat = 1;
                $getVid = 1;
                $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['user' => $userID]);

                $allVideo = $this->get('knp_paginator')->paginate
                (
                    $mainVideos,
                    $request->query->getInt('page', 1),
                    32
                );

                return $this->render('main/video.html.twig', [
                    'sq_vid' => $allVideo,
                    'sq_data' => $mainCategories,
                    'getCat' => $getCat,
                    'user' => $userName,
                    'viid' => $videoid,
                    'prj' => $getProj,
                ]);
            } else {
                foreach ($videoid as $video) {
                    $vl[] = $video->getVideo()->getId();
                }
                $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findBy(['category' => $id]);
                var_dump($mainVideos);
                $vidlist = $this->getDoctrine()->getRepository(Video::class);
                $getProj = 0;
                $sck = $vidlist->findVideo($vl);

                {
                    $allVideo = $this->get('knp_paginator')->paginate
                    (
                        $mainVideos,
                        $request->query->getInt('page', 1),
                        32
                    );

                    return $this->render('main/video.html.twig', [
                        'sq_vid' => $allVideo,
                        'sq_data' => $mainCategories,
                        'getCat' => $getCat,
                        'getVid' => $getVid,
                        'user' => $userName,
                        'viid' => $videoid,
                        'nonviid' => $sck,
                        'prj' => $getProj,
                    ]);
                }
            }
        }else {
            $userID = null;
            $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
            $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findBy(['category' => $id]);
            $getCat = 1;
            $getVid = 1;
            $getProj = 0;
            $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['user' => $userID]);
            $allVideo = $this->get('knp_paginator')->paginate
            (
                $mainVideos,
                $request->query->getInt('page', 1),
                32
            );

            return $this->render('main/video.html.twig', [
                'sq_vid' => $allVideo,
                'sq_data' => $mainCategories,
                'getCat' => $getCat,
                'user' => $userName,
                'viid' => $videoid,
                'prj' => $getProj,
            ]);
        }
    }

    /**
     * Маршрут получение проектов
     * @Route ("/projects", name = "getProjects")
     */
    public function getProjects(Request $request, PaginatorInterface $paginator)
    {
        $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
        $mainProject = $this->getDoctrine()->getRepository(Project::class)->findAll();
        $getCat = 1;
        $getVid = 1;

        $userName = $this->getUser();

        if ($userName != null) {
            $userID = $this->getUser()->id;

            $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findBy(['user' => $userID]);

            if ($videoid == null) {
                $userID = -1;
                $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
                $mainProject = $this->getDoctrine()->getRepository(Project::class)->findAll();
                $getCat = 1;
                $getVid = 1;
                $getProj = 1;
                $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['user' => $userID]);
                $allProject = $this->get('knp_paginator')->paginate
                (
                    $mainProject,
                    $request->query->getInt('page', 1),
                    32
                );

                return $this->render('main/video.html.twig', [
                    'sq_vid' => $allProject,
                    'sq_data' => $mainCategories,
                    'getCat' => $getCat,
                    'user' => $userName,
                    'viid' => $videoid,
                    'prj' => $getProj,
                ]);
            } else {
                foreach ($videoid as $video) {
                    $vl[] = $video->getVideo()->getId();
                }
                $getProj = 1;
                $vidlist = $this->getDoctrine()->getRepository(Video::class);

                $sck = $vidlist->findVideo($vl);
                $mainProject = $this->getDoctrine()->getRepository(Project::class)->findAll();
                {
                    $allVideo = $this->get('knp_paginator')->paginate
                    (
                        $mainProject,
                        $request->query->getInt('page', 1),
                        32
                    );

                    return $this->render('main/video.html.twig', [
                        'sq_vid' => $allVideo,
                        'sq_data' => $mainCategories,
                        'getCat' => $getCat,
                        'getVid' => $getVid,
                        'user' => $userName,
                        'viid' => $videoid,
                        'nonviid' => $sck,
                        'prj' => $getProj,
                    ]);
                }
            }
        }else {
            $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
            $mainVideos = $this->getDoctrine()->getRepository(Project::class)->findAll();
            $getCat = 1;
            $getProj = 1;
            $allVideo = $this->get('knp_paginator')->paginate
            (
                $mainVideos,
                $request->query->getInt('page', 1),
                32
            );

            return $this->render('main/video.html.twig', [
                'sq_vid' => $allVideo,
                'sq_data' => $mainCategories,
                'getCat' => $getCat,
                'user' => $userName,
                'prj' =>$getProj,
            ]);
        }
    }

    /**
     * Маршрут получения видео
     * @Route("/videos", name="getVideos")
     */
    public function getVideos(Request $request, PaginatorInterface $paginator)
    {
        $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
        $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findAll();
        $getCat = 1;
        $getVid = 1;
        $getProj = 0;

        $userName = $this->getUser();

        if ($userName != null) {
            $userID = $this->getUser()->id;

            $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findBy(['user' => $userID]);

            if ($videoid == null) {
                $userID = -1;
                $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
                $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findAll();
                $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['user' => $userID]);
                $allVideo = $this->get('knp_paginator')->paginate
                (
                    $mainVideos,
                    $request->query->getInt('page', 1),
                    32
                );

                return $this->render('main/video.html.twig', [
                    'sq_vid' => $allVideo,
                    'sq_data' => $mainCategories,
                    'getCat' => $getCat,
                    'user' => $userName,
                    'viid' => $videoid,
                    'prj' => $getProj,
                ]);
            } else {
                foreach ($videoid as $video) {
                    $vl[] = $video->getVideo()->getId();
                }

                $vidlist = $this->getDoctrine()->getRepository(Video::class);

                $sck = $vidlist->findVideo($vl);

                {
                    $allVideo = $this->get('knp_paginator')->paginate
                    (
                        $mainVideos,
                        $request->query->getInt('page', 1),
                        32
                    );

                    return $this->render('main/video.html.twig', [
                        'sq_vid' => $allVideo,
                        'sq_data' => $mainCategories,
                        'getCat' => $getCat,
                        'getVid' => $getVid,
                        'user' => $userName,
                        'viid' => $videoid,
                        'nonviid' => $sck,
                        'prj' => $getProj,
                    ]);
                }
            }
        }else
            {
                $userID = -1;
                $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
                $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findAll();
                $getCat = 1;
                $getVid = 1;
                $getProj = 0;
                $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['user' => $userID]);
                $allVideo = $this->get('knp_paginator')->paginate
                (
                    $mainVideos,
                    $request->query->getInt('page', 1),
                    32
                );

                return $this->render('main/video.html.twig', [
                    'sq_vid' => $allVideo,
                    'sq_data' => $mainCategories,
                    'getCat' => $getCat,
                    'user' => $userName,
                    'viid' => $videoid,
                    'prj' => $getProj,
                ]);
            }
    }

    /**
     * Маршрут получение проектов
     * @Route ("/projects/{id}", name = "getProjectsVideo")
     */
    public function getPojectasVid($id, Request $request, PaginatorInterface $paginator)
    {
        $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();

        $getCat = 1;
        $getVid = 1;

        $userName = $this->getUser();

        if ($userName != null) {
            $userID = $this->getUser()->id;

            $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findBy(['user' => $userID]);

            if ($videoid == null) {
                $userID = -1;
                $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
                $mainProject = $this->getDoctrine()->getRepository(Video::class)->findBy(['project' => $id]);
                $getCat = 1;
                $getVid = 1;
                $getProj = 0;
                $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['user' => $userID]);
                $allProject = $this->get('knp_paginator')->paginate
                (
                    $mainProject,
                    $request->query->getInt('page', 1),
                    32
                );

                return $this->render('main/video.html.twig', [
                    'sq_vid' => $allProject,
                    'sq_data' => $mainCategories,
                    'getCat' => $getCat,
                    'user' => $userName,
                    'viid' => $videoid,
                    'prj' => $getProj,
                ]);
            } else {
                foreach ($videoid as $video) {
                    $vl[] = $video->getVideo()->getId();
                }
                $getProj = 0;
                $vidlist = $this->getDoctrine()->getRepository(Video::class);

                $sck = $vidlist->findVideo($vl);
                $mainProject = $this->getDoctrine()->getRepository(Video::class)->findBy(['project' => $id]);
                {
                    $allVideo = $this->get('knp_paginator')->paginate
                    (
                        $mainProject,
                        $request->query->getInt('page', 1),
                        32
                    );

                    return $this->render('main/video.html.twig', [
                        'sq_vid' => $allVideo,
                        'sq_data' => $mainCategories,
                        'getCat' => $getCat,
                        'getVid' => $getVid,
                        'user' => $userName,
                        'viid' => $videoid,
                        'nonviid' => $sck,
                        'prj' => $getProj,
                    ]);
                }
            }
        } else {
            $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
            $mainProject = $this->getDoctrine()->getRepository(Video::class)->findBy(['project' => $id]);
            $getCat = 1;
            $getProj = 0;
            $allVideo = $this->get('knp_paginator')->paginate
            (
                $mainProject,
                $request->query->getInt('page', 1),
                32
            );

            return $this->render('main/video.html.twig', [
                'sq_vid' => $allVideo,
                'sq_data' => $mainCategories,
                'getCat' => $getCat,
                'user' => $userName,
                'prj' => $getProj,
            ]);
        }
    }
}
