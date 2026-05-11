<?php
require_once('../config.php');

if(isset($_GET['busca'])){
    $termo = $_GET['busca'];

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/searchbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <div class="position-relative">
        <form action="" method="get">
        <i class="fas fa-search lupa"></i>
        <input type="text" name="busca" placeholder="Pesquisar..." class="search ">
        </form>
    </div>
</body>
</html>
