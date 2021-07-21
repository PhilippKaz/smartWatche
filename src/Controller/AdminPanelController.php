<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Video;
use App\Entity\Project;
use App\Entity\Videolist;

class AdminPanelController extends Controller
{
    /**
     * Переход на панель администратора
     * @Route("adminPanel", name="admin_panel")
     */
    public function index()
    {
        $user = $this->getUser();
        $countCategory = count($this->getDoctrine()->getRepository(Category::class)->findAll());
        $countUser = count($this->getDoctrine()->getRepository(User::class)->findAll());
        $countVideo = count($this->getDoctrine()->getRepository(Video::class)->findAll());
        $countProject = count($this->getDoctrine()->getRepository(Project::class)->findAll());
        $countAddedvideo = count($this->getDoctrine()->getRepository(Videolist::class)->findAll());

        return $this->render('admin_panel/index.html.twig', [
            'controller_name' => 'AdminPanelController',
            'user' => $user,
            'countCategory' => $countCategory,
            'countUser' => $countUser,
            'countVideo'=>$countVideo,
            'countProject'=>$countProject,
            'countAddedvideo'=>$countAddedvideo,
        ]);
    }
}
