<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dataBase = "pam";

    $config = new mysqli($hostname, $username, $password, $dataBase);

    if($config -> connect_error){
        echo "Erro na conexão" . $config->connect_error;
    }