<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Category;
use App\Entity\Video;
use App\Entity\Videolist;

class InverseController extends Controller //Инверсия цветов
{
    private $session;

    public function __construct(SessionInterface $session) //определение сессии
    {
        $this->session = $session;
    }

    /**
     * Маршрут изменении темы
     * @Route ("/change_theme", name="change_theme")
     */
    public function change_theme(SessionInterface $session, PaginatorInterface $paginator, Request $request)
    {
        $prj = 0;
        if ($session->get('theme') != null)
        {
            if ($session->get('theme')['title'] == 'light')
            {
                $session->set('theme', ['title' => 'dark']);
            }
            else
            {
                $session->set('theme', ['title' => 'light']);
            }
        }
        return $this->redirectToRoute("main");
    }
}
