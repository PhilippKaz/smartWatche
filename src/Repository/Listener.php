<?php

namespace App\Repository;


use App\Entity\Category;
use App\Entity\Genre;
use App\Repository\ProjectRepository;
use App\Service\VideoServices;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Project;
use App\Entity\Video;
use Symfony\Component\DependencyInjection\Tests\Compiler\C;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * Class Listener
 * @package App\Repository
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 */
class Listener implements \JsonFileParser\Listener
{
    /**
     * json объект
     * @param string $jsonObject
     */
    private $repository;


    public function setRepository ($repository) //получение определенного репозитория
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }




    public function onObjectFound($jsonObject) //Добавление данных в БД
    {
        $object = json_decode($jsonObject);

       /* $idd = $object->relationships->project->id;
        $title =  $object->relationships->project->title;
        $cover = $object->meta->cover;
        $updated = $object->date->updated;


        $project = new Project();
        $project->setIdd($idd);
        $project->setTitle($title);
        $project->setCover($cover);
        $project->setUpdatedAt($updated);*/



        /*$project = new Project();

        $id_project = $object->relationships->project->id;
        $title =  $object->relationships->project->title;
        $cover = $object->meta->cover;
        $created = $object->date->created;
        $category = $object->relationships->category->id;
        $cr = $this->repository->getRepository(Category::class)->findOneBy(['id' => $category]);
        $entityManager = $this->repository->getManager();



            $date = new \DateTime($created);
            $ndate = $date->format('d/m/Y H:i:s');
            $project->setIdd($id_project);
            $project->setTitle($title);
            $project->setUpdatedAt($ndate);
            $project->setCategory($cr);
            $project->setCover($cover);
            $entityManager->persist($project);
            $entityManager->flush();*/

       /* $entityManager = $this->repository->getManager();

        $cr = $this->repository->getRepository(Category::class)->findOneBy(['id' => $category]);
        $project->setIdd($id_project);
        $project->setTitle($title);
        $project->setUpdatedAt($created);
        $project->setCategory($cr);
        $project->setCover($cover);
        $entityManager->persist($project);
        $entityManager->flush();*/

        /*$project->setIdd($id_project);
        $project->setTitle($title);
        $project->setUpdatedAt($created);
        $project->setCategory($cr);
        $project->setCover($cover);
        $entityManager->persist($project);
        $entityManager->flush();



       /* $video = new Video();
        $idd = $object->id;
        $title = $object->meta->title;
        $description =  $object->meta->description;
        $cover = $object->meta->cover;
        $created = $object->date->created;
        $id_category = $object->relationships->category->id;
        $id_project = $object->relationships->project->id;*/



        $video = new Video();
        $idd = $object->id;
        $title = $object->meta->title;
        $description =  $object->meta->description;
        $cover = $object->meta->cover;
        $created = $object->date->created;
        $id_category = $object->relationships->category->id;
        $id_project = $object->relationships->project->id;

        $date = new \DateTime($created);
        $ndate = $date->format('d/m/Y H:i:s');
        $entityManager = $this->repository->getManager();

        $cr = $this->repository->getRepository(Category::class)->findOneBy(['id' => $id_category]);
        $pr = $this->repository->getRepository(Project::class)->findOneBy(['idd' => $id_project]);


        $video->setIdd($idd);
        $video->setTitle($title);
        $video->setDescription($description);
        $video->setCover($cover);
        $video->setCreated($ndate);
        $video->setCategory($cr);
        $video->setProject($pr);
        $entityManager->persist($video);
        $entityManager->flush();


        /*$video = new Video();
        $gen1 = new Genre();
        $gen2 = new Genre();


        $gen1->setTitle("test1");
        $gen2->setTitle("test2");



        $video->addGenre($gen1);
        $video->addGenre($gen2);


        $entityManager = $this->repository->getManager();



        $entityManager->persist($gen1);
        $entityManager->persist($gen2);

        $entityManager->persist($video);

        $entityManager->flush();*/



       /* $id_video = $object->id;

        $id_genre = $object->meta->genres['0']->id;

        $entityManager = $this->repository->getManager();

        $gr = $this->repository->getRepository(Genre::class)->findOneBy(['id' => $id_genre]);

        $vd = $this->repository->getRepository(Video::class)->findOneBy(['idd' => $id_video]);


        $video->addGenre($id_genre);

        $entityManager->persist($video);
        $entityManager->persist($genre);
        $entityManager->flush();*/

        // сохраняем изменения в БД


        /*$video = new Video();
        $video->setIdd($idd);
        $video->setTitle($title);
        $video->setCover($cover);
        $video->setDescription($description);
        $video->setCreated($created);


        $this->repository->persist($video);
        $this->repository->flush();*/

        /*$gen_id = $object->meta->genres['0']->id ;
        $id = $object->id;
        $video = new Video();
        $genre = new Genre();

        $genre->addVideo('test');
        $video->addGenre('test');
        $this->repository->persist($genre);
        $this->repository->persist($video);
        $this->repository->flush();*/

       /* $this->repository->persist($genre);
        $this->repository->persist($video);
        $this->repository->flush();*/

        //ЗАПРОС
       /*  DELETE FROM project
        USING project, project AS vtable
        WHERE (project.id > vtable.id)
        AND (project.title= vtable.title)*/


        //echo $object->meta->title . PHP_EOL;

        // $string = $object->name;

        //echo  $object->meta->genres['0']->title . PHP_EOL;

        //echo  date('H:i:s') . "> {$object->id}" . PHP_EOL;

        //echo  date('H:i:s') . "> {$object->meta->description}" . PHP_EOL;
        //echo  date('H:i:s') . "> {$object->meta->cover}" . PHP_EOL;
        //echo  date('H:i:s') . "> {$object->date->created}" . PHP_EOL;
        //echo (date('H:i:s') . "> {$object->meta->genres['0']->title}" . PHP_EOL);


        //echo date('H:i:s') . "> {$object->code2} - {$object->name}" . PHP_EOL;
    }


    public function onStart()
    {
       // echo date('H:i:s') . "> Начнем";
    }

    public function onEnd()
    {
        //echo date('H:i:s') . "> Готово";
    }

    public function onError(\Exception $e)
    {
       // echo date('H:i:s') . "> Exception: " . $e->getMessage();
    }

    public function onStreamRead($textChunk, $streamPosition)
    {
       // echo date('H:i:s') . ">  Длина части: " . strlen($textChunk) . ". Позиция просмотра: $streamPosition" . PHP_EOL;
    }
}

