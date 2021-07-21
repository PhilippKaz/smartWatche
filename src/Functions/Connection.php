<?php

namespace App\Functions;

class Connection
{

    function connectDB() //Подключение к API.PLadform
    {
        $host_api = "http://api.pladform.ru/";
        $array = array(
            'login'   => 'kazakovfilipp@mail.ru',
            'password' => 'qazak1488');
        // авторизация
        $curl = curl_init($host_api);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // post запрос
        curl_setopt($curl, CURLOPT_URL, "http://api.pladform.ru/auth/login?format=json");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $array);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $ssn = curl_exec($curl);
        // получение сессии
        if (preg_match('/\bfalse/',$ssn, $url_session))
        {
            $url_session = "Неправильный логин или пароль";
        }else {
            $url_session = substr($ssn, 26, -2);
        }
        //preg_match('/.{169}(?!(\d|[a-z]))/', $ssn, $output);
        //передача сессии в функцию "getCat"
        return $url_session;
    }
}