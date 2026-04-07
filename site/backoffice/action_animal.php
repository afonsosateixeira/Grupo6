<?php
require_once('config.php');

if (isset($_POST['btnCriar'])) {
    $nome = $config->real_escape_string($_POST['nome_animal']);
    $arquivo = $_FILES['image'];
    $nomeArquivo = $arquivo['name'];
    $breedID = (int) $_POST['breed_id'];
    $caminhoDestino = "assets/img/animals/" . $nomeArquivo;

    if (move_uploaded_file($arquivo['tmp_name'], $caminhoDestino)) {
        $sql = "INSERT INTO animals (name, image, breed_id) VALUES ('$nome', '$nomeArquivo', $breedID)";
        $config->query($sql);
        header("Location: animalList.php?status=criado");
    } else {
        echo "Erro ao criar.";
    }
    exit();
}

if (isset($_GET['btnEliminar'])) {
    $id = (int) $_GET['btnEliminar'];
    if ($config->query("DELETE FROM animals WHERE id = $id")) {
        header("Location: animalList.php?status=apagado");
    } else {
        echo "Erro ao eliminar " . $config->error;
    }
    exit();
}

if (isset($_GET['btnEditar'])) {
    $id = (int) $_GET['btnEditar'];
    header("Location: animalList.php?btnEditar=$id");
    exit();
}

if (isset($_POST['btnEditar'])) {
    $id = (int) $_POST['id_animal'];
    $nome = $config->real_escape_string($_POST['nome_animal']);

    if (!empty($_FILES['image']['name'])) {
        $nomeArquivo = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "assets/img/animals/" . $nomeArquivo);
        $sql = "UPDATE animals SET name = '$nome', image = '$nomeArquivo' WHERE id = $id";
    } else {
        $sql = "UPDATE animals SET name = '$nome' WHERE id = $id";
    }

    $config->query($sql);
    header("Location: animalList.php?status=editado");
    exit();
}

header("Location: animalList.php");
exit();