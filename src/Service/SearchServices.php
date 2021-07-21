<?php

namespace App\Service;

use SphinxClient;


class SearchServices
{
    public function search($slug) //Полнотекстовый поиск
    {
        // Подключим файл с api
        include('C:\Sphinx\api\sphinxapi.php');

        $product = array();

        $searchObject = array();

        // Создадим объект - клиент сфинкса и подключимся к нашей службе
        $cl = new SphinxClient();
        $cl->SetServer( "localhost", 9307 );

        // Собственно поиск
        $cl->SetMatchMode( SPH_MATCH_ANY  ); // ищем хотя бы 1 слово из поисковой фразы


        $result = $cl->Query($slug); // поисковый запрос


        // обработка результатов запроса
        if ( $result === false ) {
            echo "Запрос недуачный: " . $cl->GetLastError() . ".\n"; // выводим ошибку если произошла
        }
        else {
            if ( $cl->GetLastWarning() ) {
                 $cl->GetLastWarning() ."<br>";
            }

            if ( ! empty($result["matches"]) ) { // если есть результаты поиска - обрабатываем их
                return $result["matches"];
               /* foreach ( $result["matches"] as $product => $info ) {
                    ($product) .; // просто выводим id найденных объектов
                }*/
            }
        }
        exit;
    }
}