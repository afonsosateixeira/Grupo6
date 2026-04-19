<?php
require_once('../config.php');

$caminhoPasta = "../assets/img/animals/";

/* criar e guardar */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nome    = $config->real_escape_string($_POST['nome_animal'] ?? '');
    $breedID = (int)($_POST['breed_id'] ?? 0);
    $data    = $config->real_escape_string($_POST['data_nascimento'] ?? '');
    $genero  = $config->real_escape_string($_POST['gender'] ?? '');
    $descricao = $config->real_escape_string($_POST['description'] ?? '');

    // criar
    if (isset($_POST['btnCriar'])) {
        $nomeArquivo = $_FILES['image']['name'];
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $caminhoPasta . $nomeArquivo)) {
            $sql = "INSERT INTO animals (name, breed_id, birth_date, gender, description, image) 
                    VALUES ('$nome', $breedID, '$data', '$genero', '$descricao', '$nomeArquivo')";
            $config->query($sql);
            header("Location: animalList.php?status=criado");
        } else {
            echo "Erro ao carregar imagem de novo animal.";
        }
        exit();
    }

    // editar/guardar
    if (isset($_POST['btnEditar'])) {
        $id = (int)$_POST['id_animal'];
        
        $sql = "UPDATE animals SET 
                name = '$nome', 
                breed_id = $breedID, 
                birth_date = '$data',
                gender = '$genero',
                description = '$descricao'
                ";

        if (!empty($_FILES['image']['name'])) {
            $nomeArquivo = $_FILES['image']['name'];
            if (move_uploaded_file($_FILES['image']['tmp_name'], $caminhoPasta . $nomeArquivo)) {
                $sql .= ", image = '$nomeArquivo'";
            }
        }

        $sql .= " WHERE id = $id";
        
        $config->query($sql);
        header("Location: animalList.php?status=editado");
        exit();
    }
}

/* Botões da tabela */

// ELIMINAR
if (isset($_GET['btnEliminar'])) {
    $id = (int)$_GET['btnEliminar'];
    $config->query("DELETE FROM animals WHERE id = $id");
    header("Location: animalList.php?status=apagado");
    exit();
}

// EDITAR
if (isset($_GET['btnEditar'])) {
    $id = (int)$_GET['btnEditar'];
    header("Location: animalList.php?btnEditar=$id");
    exit();
}

header("Location: animalList.php");
exit();