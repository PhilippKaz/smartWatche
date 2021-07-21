<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Functions\Connection;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function contoDb() //Подключение к БД
    {
        $getUrl = new Connection();
        $session = $getUrl->connectDB();
        $this->getCat($session);
    }

    public function getCat($session) // Получение данных
    {
        $ch = curl_init('https://api.pladform.ru/distributor/categories?api_session' . $session);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $session, 'accept: application/hal+json'],
            CURLOPT_RETURNTRANSFER => true
        ]);
        $reg = curl_exec($ch);
        curl_close($ch);
        $this->addCat($reg);
    }

    public function addCat($categories) //Добавление данных
    {
        $obj = json_decode($categories, true);

       // $cats = array($obj, ['id', 'title']);

        foreach ($obj as $cat)
        {
            $entityManager = $this->getEntityManager();
            $category = new Category();
            $category->setId($cat['id']);
            $category->setTitle($cat['title']);
            $entityManager->persist($category);
            $entityManager->flush();
        }
    }
}
