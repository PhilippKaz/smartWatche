<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Category;
use App\Entity\Video;
use App\Entity\Genre;
use App\Entity\Project;
use App\Entity\Videolist;

use Knp\Component\Pager\PaginatorInterface;

use App\Service\SearchServices;

class SearchController extends Controller //Контроллер поиска
{
    /**
     * Полнотекстовый поиск
     * @Route("/search/{slug}", name="search")
     */
    public function search($slug, Request $request)
    {
        $bs = new SearchServices();
        $searchID = $bs->search($slug);

            foreach ($searchID as $product => $id)
            {
                $products[] = $product;
            }

            $searchVid = $this->getDoctrine()->getRepository(Video::class)->findBy(['id' => $products]);
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
                    $getCat = 1;
                    $getVid = 1;
                    $getProj = 0;
                    $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['user' => $userID]);
                    $allVideo = $this->get('knp_paginator')->paginate
                    (
                        $searchVid,
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
                            $searchVid,
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
                $userID = -1;
                $mainCategories = $this->getDoctrine()->getRepository(Category::Class)->findAll();
                $mainVideos = $this->getDoctrine()->getRepository(Video::class)->findAll();
                $getCat = 1;
                $getVid = 1;
                $getProj = 0;
                $videoid = $this->getDoctrine()->getRepository(Videolist::class)->findOneBy(['user' => $userID]);
                $allVideo = $this->get('knp_paginator')->paginate
                (
                    $searchVid,
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
}
