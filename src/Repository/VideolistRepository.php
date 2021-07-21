<?php

namespace App\Repository;

use App\Entity\Videolist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PhpParser\Node\Scalar\MagicConst\Dir;
use Symfony\Bridge\Doctrine\RegistryInterface;
use PDO;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @method Videolist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Videolist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Videolist[]    findAll()
 * @method Videolist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideolistRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Videolist::class);
    }

    public function exportFromUserPanel($id): ?array // Экспорт данных пользователей
    {
        $filename = 'W:/OSPanel/domains/watcher/public/backupuser';
        $conn = $this->getEntityManager()->getConnection();
        $sqlallTab = 'SHOW TABLES';
        $stmt = $conn->prepare($sqlallTab);
        $stmt->execute();
        $allTab = $stmt->fetchAll();

        if (file_exists($filename)) { //добавленные видео
            $conn = $this->getEntityManager()->getConnection();
            $sqlallTab = 'SHOW TABLES';
            $stmt = $conn->prepare($sqlallTab);
            $stmt->execute();

            $allTab = $stmt->fetchAll();

            foreach ($allTab as $row) {
                $output = '';
                foreach ($allTab['6'] as $table) {
                    $show_table_query = "SHOW CREATE TABLE `videolist`";
                    $stmt = $conn->prepare($show_table_query);
                    $stmt->execute();
                    $tab_result = $stmt->fetchAll();

                    foreach ($tab_result as $tab_res_row) {
                        $output .= "\n\n" . $tab_res_row["Create Table"] . ";\n\n";
                    }

                    $select_query = "SELECT `id`, `title`,`description`,`created`,`cover`,`added` FROM `videolist` WHERE `user_id` = $id";

                    $stmt = $conn->prepare($select_query);
                    $stmt->execute();

                    $total_row = $stmt->rowCount();

                    for ($count = 0; $count < $total_row; $count++) {
                        $single_result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $table_column_array = array_keys($single_result);
                        $table_value_array = array_values($single_result);
                        $output .= "\nINSERT INTO `videolist`(";
                        $output .= "" . implode(",", $table_column_array) . ")
                                            VALUES (";
                        $output .= "" . implode("','", $table_value_array) . ");
                                          \n";
                    }
                }
            }
        } else {
            mkdir("W:/OSPanel/domains/watcher/public/backupuser", 0777);
            foreach ($allTab as $row) {
                $output = '';
                foreach ($allTab['6'] as $table) {
                    $show_table_query = "SHOW CREATE TABLE `videolist`";
                    $stmt = $conn->prepare($show_table_query);
                    $stmt->execute();
                    $tab_result = $stmt->fetchAll();

                    foreach ($tab_result as $tab_res_row) {
                        $output .= "\n\n" . $tab_res_row["Create Table"] . ";\n\n";
                    }

                    $select_query = "SELECT `id`, `title`,`description`,`created`,`cover`,`added` FROM `videolist` WHERE `user_id` = $id";

                    $stmt = $conn->prepare($select_query);
                    $stmt->execute();

                    $total_row = $stmt->rowCount();

                    for ($count = 0; $count < $total_row; $count++) {
                        $single_result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $table_column_array = array_keys($single_result);
                        $table_value_array = array_values($single_result);
                        $output .= "\nINSERT INTO `videolist`(";
                        $output .= "" . implode(",", $table_column_array) . ")
                                            VALUES (";
                        $output .= "" . implode("','", $table_value_array) . ");
                                          \n";
                    }
                }
            }
        }
        $filename = 'W:/OSPanel/domains/watcher/public/backupuser/backup' . date('dmY-His') . '.sql';
        $hundle = fopen($filename, 'w+');
        fwrite($hundle, $output);
        fclose($hundle);
        return null;
    }


    public function exportFromAdminPanel(): ?array //Экспорт данных из БД
    {
        /**/

        $filename = 'W:/OSPanel/domains/watcher/public/backupadmin';

        if (file_exists($filename)) { //видео
            $conn = $this->getEntityManager()->getConnection();
            $sqlallTab = 'SHOW TABLES';
            $stmt = $conn->prepare($sqlallTab);
            $stmt->execute();

            $allTab = $stmt->fetchAll();

            foreach ($allTab as $row) {
                $output = '';
                foreach ($allTab['5'] as $table) {
                    $show_table_query = "SHOW CREATE TABLE `video`";
                    $stmt = $conn->prepare($show_table_query);
                    $stmt->execute();
                    $tab_result = $stmt->fetchAll();

                    foreach ($tab_result as $tab_res_row) {
                        $output .= "\n\n" . $tab_res_row["Create Table"] . ";\n\n";
                    }

                    $select_query = "SELECT * FROM `video`";

                    $stmt = $conn->prepare($select_query);
                    $stmt->execute();

                    $total_row = $stmt->rowCount();

                    for ($count = 0; $count < $total_row; $count++) {
                        $single_result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $table_column_array = array_keys($single_result);
                        $table_value_array = array_values($single_result);
                        $output .= "\nINSERT INTO `video`(";
                        $output .= "" . implode(",", $table_column_array) . ")
                                            VALUES (";
                        $output .= "" . implode("','", $table_value_array) . ");
                                          \n";
                    }
                }
                $filename = 'W:/OSPanel/domains/watcher/public/backupadmin/video.' . 'sql';
                $hundle = fopen($filename, 'w+');
                fwrite($hundle, $output);
                fclose($hundle);

            }
        } else {
            mkdir("W:/OSPanel/domains/watcher/public/backupadmin", 0777);
            $conn = $this->getEntityManager()->getConnection();
            $sqlallTab = 'SHOW TABLES';
            $stmt = $conn->prepare($sqlallTab);
            $stmt->execute();

            $allTab = $stmt->fetchAll();

            foreach ($allTab as $row) {
                $output = '';
                foreach ($allTab['5'] as $table) {
                    $show_table_query = "SHOW CREATE TABLE `video`";
                    $stmt = $conn->prepare($show_table_query);
                    $stmt->execute();
                    $tab_result = $stmt->fetchAll();

                    foreach ($tab_result as $tab_res_row) {
                        $output .= "\n\n" . $tab_res_row["Create Table"] . ";\n\n";
                    }

                    $select_query = "SELECT * FROM `video`";

                    $stmt = $conn->prepare($select_query);
                    $stmt->execute();

                    $total_row = $stmt->rowCount();

                    for ($count = 0; $count < $total_row; $count++) {
                        $single_result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $table_column_array = array_keys($single_result);
                        $table_value_array = array_values($single_result);
                        $output .= "\nINSERT INTO `video`(";
                        $output .= "" . implode(",", $table_column_array) . ")
                                            VALUES (";
                        $output .= "" . implode("','", $table_value_array) . ");
                                          \n";
                    }
                }
                //Запись данных в файл
                $filename = 'W:/OSPanel/domains/watcher/public/backupadmin/video.' . 'sql';
                $hundle = fopen($filename, 'w+');
                fwrite($hundle, $output);
                fclose($hundle);

            }
        }


        if (file_exists($filename)) {//категории
            $conn = $this->getEntityManager()->getConnection();
            $sqlallTab = 'SHOW TABLES';
            $stmt = $conn->prepare($sqlallTab);
            $stmt->execute();

            $allTab = $stmt->fetchAll();

            foreach ($allTab as $row) {
                $output = '';
                foreach ($allTab['0'] as $table) {
                    $show_table_query = "SHOW CREATE TABLE `category`";
                    $stmt = $conn->prepare($show_table_query);
                    $stmt->execute();
                    $tab_result = $stmt->fetchAll();

                    foreach ($tab_result as $tab_res_row) {
                        $output .= "\n\n" . $tab_res_row["Create Table"] . ";\n\n";
                    }

                    $select_query = "SELECT * FROM `category`";

                    $stmt = $conn->prepare($select_query);
                    $stmt->execute();

                    $total_row = $stmt->rowCount();

                    for ($count = 0; $count < $total_row; $count++) {
                        $single_result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $table_column_array = array_keys($single_result);
                        $table_value_array = array_values($single_result);
                        $output .= "\nINSERT INTO `category`(";
                        $output .= "" . implode(",", $table_column_array) . ")
                                            VALUES (";
                        $output .= "" . implode("','", $table_value_array) . ");
                                          \n";
                    }
                }
                $filename = 'W:/OSPanel/domains/watcher/public/backupadmin/category.' . 'sql';
                $hundle = fopen($filename, 'w+');
                fwrite($hundle, $output);
                fclose($hundle);
            }
        } else {
            mkdir("W:/OSPanel/domains/watcher/public/backupadmin", 0777);
            $conn = $this->getEntityManager()->getConnection();
            $sqlallTab = 'SHOW TABLES';
            $stmt = $conn->prepare($sqlallTab);
            $stmt->execute();

            $allTab = $stmt->fetchAll();

            foreach ($allTab as $row) {
                $output = '';
                foreach ($allTab['0'] as $table) {
                    $show_table_query = "SHOW CREATE TABLE `category`";
                    $stmt = $conn->prepare($show_table_query);
                    $stmt->execute();
                    $tab_result = $stmt->fetchAll();

                    foreach ($tab_result as $tab_res_row) {
                        $output .= "\n\n" . $tab_res_row["Create Table"] . ";\n\n";
                    }

                    $select_query = "SELECT * FROM `category`";

                    $stmt = $conn->prepare($select_query);
                    $stmt->execute();

                    $total_row = $stmt->rowCount();

                    for ($count = 0; $count < $total_row; $count++) {
                        $single_result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $table_column_array = array_keys($single_result);
                        $table_value_array = array_values($single_result);
                        $output .= "\nINSERT INTO `category`(";
                        $output .= "" . implode(",", $table_column_array) . ")
                                            VALUES (";
                        $output .= "" . implode("','", $table_value_array) . ");
                                          \n";
                    }
                }
                //Запись данных в файл
                $filename = 'W:/OSPanel/domains/watcher/public/backupadmin/category.' . 'sql';
                $hundle = fopen($filename, 'w+');
                fwrite($hundle, $output);
                fclose($hundle);
            }
        }
        if (file_exists($filename)) { //пользователь
            $conn = $this->getEntityManager()->getConnection();
            $sqlallTab = 'SHOW TABLES';
            $stmt = $conn->prepare($sqlallTab);
            $stmt->execute();

            $allTab = $stmt->fetchAll();

            foreach ($allTab as $row) {
                $output = '';
                foreach ($allTab['1'] as $table) {
                    $show_table_query = "SHOW CREATE TABLE `fos_user`";
                    $stmt = $conn->prepare($show_table_query);
                    $stmt->execute();
                    $tab_result = $stmt->fetchAll();

                    foreach ($tab_result as $tab_res_row) {
                        $output .= "\n\n" . $tab_res_row["Create Table"] . ";\n\n";
                    }

                    $select_query = "SELECT * FROM `fos_user`";

                    $stmt = $conn->prepare($select_query);
                    $stmt->execute();

                    $total_row = $stmt->rowCount();

                    for ($count = 0; $count < $total_row; $count++) {
                        $single_result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $table_column_array = array_keys($single_result);
                        $table_value_array = array_values($single_result);
                        $output .= "\nINSERT INTO `fos_user`(";
                        $output .= "" . implode(",", $table_column_array) . ")
                                            VALUES (";
                        $output .= "" . implode("','", $table_value_array) . ");
                                          \n";
                    }
                }
                $filename = 'W:/OSPanel/domains/watcher/public/backupadmin/user.' . 'sql';
                $hundle = fopen($filename, 'w+');
                fwrite($hundle, $output);
                fclose($hundle);
            }
        } else {
            mkdir("W:/OSPanel/domains/watcher/public/backupadmin", 0777);
            $conn = $this->getEntityManager()->getConnection();
            $sqlallTab = 'SHOW TABLES';
            $stmt = $conn->prepare($sqlallTab);
            $stmt->execute();

            $allTab = $stmt->fetchAll();

            foreach ($allTab as $row) {
                $output = '';
                foreach ($allTab['1'] as $table) {
                    $show_table_query = "SHOW CREATE TABLE `fos_user'";
                    $stmt = $conn->prepare($show_table_query);
                    $stmt->execute();
                    $tab_result = $stmt->fetchAll();

                    foreach ($tab_result as $tab_res_row) {
                        $output .= "\n\n" . $tab_res_row["Create Table"] . ";\n\n";
                    }

                    $select_query = "SELECT * FROM `fos_user`";

                    $stmt = $conn->prepare($select_query);
                    $stmt->execute();

                    $total_row = $stmt->rowCount();

                    for ($count = 0; $count < $total_row; $count++) {
                        $single_result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $table_column_array = array_keys($single_result);
                        $table_value_array = array_values($single_result);
                        $output .= "\nINSERT INTO `fos_user`(";
                        $output .= "" . implode(",", $table_column_array) . ")
                                            VALUES (";
                        $output .= "" . implode("','", $table_value_array) . ");
                                          \n";
                    }
                }
                //Запись данных в файл
                $filename = 'W:/OSPanel/domains/watcher/public/backupadmin/user.' . 'sql';
                $hundle = fopen($filename, 'w+');
                fwrite($hundle, $output);
                fclose($hundle);
            }
        }

        if (file_exists($filename)) { //проекты
            $conn = $this->getEntityManager()->getConnection();
            $sqlallTab = 'SHOW TABLES';
            $stmt = $conn->prepare($sqlallTab);
            $stmt->execute();

            $allTab = $stmt->fetchAll();

            foreach ($allTab as $row) {
                $output = '';
                foreach ($allTab['5'] as $table) {
                    $show_table_query = "SHOW CREATE TABLE `project`";
                    $stmt = $conn->prepare($show_table_query);
                    $stmt->execute();
                    $tab_result = $stmt->fetchAll();

                    foreach ($tab_result as $tab_res_row) {
                        $output .= "\n\n" . $tab_res_row["Create Table"] . ";\n\n";
                    }

                    $select_query = "SELECT * FROM `project`";

                    $stmt = $conn->prepare($select_query);
                    $stmt->execute();

                    $total_row = $stmt->rowCount();

                    for ($count = 0; $count < $total_row; $count++) {
                        $single_result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $table_column_array = array_keys($single_result);
                        $table_value_array = array_values($single_result);
                        $output .= "\nINSERT INTO `project`(";
                        $output .= "" . implode(",", $table_column_array) . ")
                                            VALUES (";
                        $output .= "" . implode("','", $table_value_array) . ");
                                          \n";
                    }
                }
                $filename = 'W:/OSPanel/domains/watcher/public/backupadmin/project.' . 'sql';
                $hundle = fopen($filename, 'w+');
                fwrite($hundle, $output);
                fclose($hundle);
            }
        } else {
            mkdir("W:/OSPanel/domains/watcher/public/backupadmin", 0777);
            $conn = $this->getEntityManager()->getConnection();
            $sqlallTab = 'SHOW TABLES';
            $stmt = $conn->prepare($sqlallTab);
            $stmt->execute();

            $allTab = $stmt->fetchAll();

            foreach ($allTab as $row) {
                $output = '';
                foreach ($allTab['5'] as $table) {
                    $show_table_query = "SHOW CREATE TABLE `project'";
                    $stmt = $conn->prepare($show_table_query);
                    $stmt->execute();
                    $tab_result = $stmt->fetchAll();

                    foreach ($tab_result as $tab_res_row) {
                        $output .= "\n\n" . $tab_res_row["Create Table"] . ";\n\n";
                    }

                    $select_query = "SELECT * FROM `project`";

                    $stmt = $conn->prepare($select_query);
                    $stmt->execute();

                    $total_row = $stmt->rowCount();

                    for ($count = 0; $count < $total_row; $count++) {
                        $single_result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $table_column_array = array_keys($single_result);
                        $table_value_array = array_values($single_result);
                        $output .= "\nINSERT INTO `project`(";
                        $output .= "" . implode(",", $table_column_array) . ")
                                            VALUES (";
                        $output .= "" . implode("','", $table_value_array) . ");
                                          \n";
                    }
                }
                //Запись данных в файл
                $filename = 'W:/OSPanel/domains/watcher/public/backupadmin/project.' . 'sql';
                $hundle = fopen($filename, 'w+');
                fwrite($hundle, $output);
                fclose($hundle);
            }
        }

        if (file_exists($filename)) { //добавленные видео
            $conn = $this->getEntityManager()->getConnection();
            $sqlallTab = 'SHOW TABLES';
            $stmt = $conn->prepare($sqlallTab);
            $stmt->execute();

            $allTab = $stmt->fetchAll();

            foreach ($allTab as $row) {
                $output = '';
                foreach ($allTab['5'] as $table) {
                    $show_table_query = "SHOW CREATE TABLE `videolist`";
                    $stmt = $conn->prepare($show_table_query);
                    $stmt->execute();
                    $tab_result = $stmt->fetchAll();

                    foreach ($tab_result as $tab_res_row) {
                        $output .= "\n\n" . $tab_res_row["Create Table"] . ";\n\n";
                    }

                    $select_query = "SELECT * FROM `videolist`";

                    $stmt = $conn->prepare($select_query);
                    $stmt->execute();

                    $total_row = $stmt->rowCount();

                    for ($count = 0; $count < $total_row; $count++) {
                        $single_result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $table_column_array = array_keys($single_result);
                        $table_value_array = array_values($single_result);
                        $output .= "\nINSERT INTO `videolist`(";
                        $output .= "" . implode(",", $table_column_array) . ")
                                            VALUES (";
                        $output .= "" . implode("','", $table_value_array) . ");
                                          \n";
                    }
                }
                $filename = 'W:/OSPanel/domains/watcher/public/backupadmin/videolist.' . 'sql';
                $hundle = fopen($filename, 'w+');
                fwrite($hundle, $output);
                fclose($hundle);
            }
        } else {
            mkdir("W:/OSPanel/domains/watcher/public/backupadmin", 0777);
            $conn = $this->getEntityManager()->getConnection();
            $sqlallTab = 'SHOW TABLES';
            $stmt = $conn->prepare($sqlallTab);
            $stmt->execute();

            $allTab = $stmt->fetchAll();

            foreach ($allTab as $row) {
                $output = '';
                foreach ($allTab['5'] as $table) {
                    $show_table_query = "SHOW CREATE TABLE `videolist'";
                    $stmt = $conn->prepare($show_table_query);
                    $stmt->execute();
                    $tab_result = $stmt->fetchAll();

                    foreach ($tab_result as $tab_res_row) {
                        $output .= "\n\n" . $tab_res_row["Create Table"] . ";\n\n";
                    }

                    $select_query = "SELECT * FROM `videolist`";

                    $stmt = $conn->prepare($select_query);
                    $stmt->execute();

                    $total_row = $stmt->rowCount();

                    for ($count = 0; $count < $total_row; $count++) {
                        $single_result = $stmt->fetch(PDO::FETCH_ASSOC);
                        $table_column_array = array_keys($single_result);
                        $table_value_array = array_values($single_result);
                        $output .= "\nINSERT INTO `videolist`(";
                        $output .= "" . implode(",", $table_column_array) . ")
                                            VALUES (";
                        $output .= "" . implode("','", $table_value_array) . ");
                                          \n";
                    }
                }
                //Запись данных в файл
                $filename = 'W:/OSPanel/domains/watcher/public/backupadmin/videolist.' . 'sql';
                $hundle = fopen($filename, 'w+');
                fwrite($hundle, $output);
                fclose($hundle);
            }
        }



        return null;
    }
}
