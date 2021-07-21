<?php

namespace App\Service;



use App\Repository\Listener;
use JsonFileParser\Parser;

require_once 'W:\OSPanel\domains\watcher\vendor\autoload.php';


class VideoServices
{
    private $repository;
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    public function getDat() //Получение данных и передача их в Listener
    {
        $filename = "W:/OSPanel/domains/watcher/public/videos.json";
        if (isset($filename))
        {
            $listener = new Listener();

            $listener->setRepository($this->repository);

            $parser = new \JsonFileParser\Parser(4096, null);

            $parser->parse($filename, $listener);
        }
        else
        {
            echo "файл не нейден";
        }
    }
}
