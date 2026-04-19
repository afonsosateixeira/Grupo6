<?php
require_once('../config.php');

/* criar e guardar */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nome    = $config->real_escape_string($_POST['full_name'] ?? '');
    $email   = $config->real_escape_string($_POST['email'] ?? '');
    $phone   = $config->real_escape_string($_POST['phone'] ?? '');
    $house   = $config->real_escape_string($_POST['house_type'] ?? '');

    // criar
    if (isset($_POST['btnCriar'])) {
        $sql = "INSERT INTO adopters (full_name, email, phone, house_type) 
                VALUES ('$nome', '$email', '$phone', '$house')";
        
        if ($config->query($sql)) {
            header("Location: adopterList.php?status=criado");
        } else {
            echo "Erro ao criar adotante: " . $config->error;
        }
        exit();
    }

    // editar/ guardar
    if (isset($_POST['btnEditar'])) {
        $id = (int)$_POST['id_adotante'];
        
        $sql = "UPDATE adopters SET 
                full_name = '$nome', 
                email = '$email', 
                phone = '$phone',
                house_type = '$house' 
                WHERE id = $id";

        if ($config->query($sql)) {
            header("Location: adopterList.php?status=editado");
        } else {
            echo "Erro ao editar adotante: " . $config->error;
        }
        exit();
    }
}

/* Botões da tabela*/

// ELIMINAR
if (isset($_GET['btnEliminar'])) {
    $id = (int)$_GET['btnEliminar'];
    $config->query("DELETE FROM adopters WHERE id = $id");
    header("Location: adopterList.php?status=apagado");
    exit();
}

// EDITAR
if (isset($_GET['btnEditar'])) {
    $id = (int)$_GET['btnEditar'];
    header("Location: adopterList.php?btnEditar=$id");
    exit();
}

header("Location: adopterList.php");
exit();