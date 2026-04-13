<?php
require_once('config.php');

if (isset($_POST['btnCriar'])) {
    $nome = $config->real_escape_string($_POST['full_name']);
    $email = $config->real_escape_string($_POST['email']);
    $numtele = $config->real_escape_string($_POST['phone']);

    if ($config->query("INSERT INTO adopters (full_name, email, phone)  VALUES ('$nome','$email', '$numtele')")) {
        header("Location: adopterList.php?status=criado");
    } else {
        echo "Erro ao criar.";
    }
    exit();
}


if (isset($_GET['btnEditar'])) {
    $id = (int) $_GET['btnEditar'];

    header("location: adopterList.php?btnEditar=$id");
    exit();
}

if (isset($_POST['btnEditar'])) {
    $id = (int) $_POST['id_adotante'];
    $nome = $config->real_escape_string($_POST['full_name']);
    $email = $config->real_escape_string($_POST['email']);
    $numtele = $config->real_escape_string($_POST['phone']);

    if ($config->query("UPDATE adopters SET full_name = '$nome', email = '$email', phone = '$numtele' WHERE id = $id")) {

    } else {
        echo "Erro ao editar.";
    }
    header("Location: adopterList.php?status=editado");
    exit();
}



if (isset($_GET['btnEliminar'])) {
    $id = (int) $_GET['btnEliminar'];
    if ($config->query("DELETE FROM adopters WHERE id = $id")) {
        header("Location: adopterList.php?status=apagado");
    } else {
        echo "Erro ao eliminar " . $config->error;
    }
    exit();
}
?>