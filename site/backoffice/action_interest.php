<?php
    require_once('config.php');

    if(isset($_POST['btnEnviar'])){
    $animal_id = (int)$_POST['animal_id'];
    $nome = $config->real_escape_string($_POST['full_name']);
    $email = $config->real_escape_string($_POST['email']);
    $phone = $config->real_escape_string($_POST['phone']);

    $checkAdotante = $config->query("SELECT id FROM adopters WHERE email = '$email'");
    
    if($checkAdotante->num_rows > 0){
        $adotante = $checkAdotante->fetch_assoc();
        $adotante_id = $adotante['id'];
    } else {
        $config->query("INSERT INTO adopters (full_name, email, phone) VALUES ('$nome', '$email', '$phone')");
        $adotante_id = $config->insert_id;
    }

    $sqlProcesso = "INSERT INTO adoption_processes (adopter_id, animal_id, status) 
                    VALUES ($adotante_id, $animal_id, 'pendente')";

    if($config->query($sqlProcesso)){
        header("Location: animalCatalog.php?sucesso=1");
    } else {
        echo "Erro ao processar: " . $config->error;
    }
    exit();
}
?>