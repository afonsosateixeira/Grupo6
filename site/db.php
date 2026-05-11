<?php
	require_once 'config.php';

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($conn->connect_error)
        echo 'Erro na conexão'.$conn->$connect_error;