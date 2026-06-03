<?php
    require_once '../../db.php';
    $Pasta = "../../assets/img/vet/";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $id = (int)$_POST['id_vet'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');


        
        if (isset($_POST['btnCriar'])) {
            $nomeArquivo = "";

            if (!empty($_FILES['image']['name'])) {
                $extensao = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $nomeArquivo = uniqid('vet_', true) . '.' . $extensao;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $Pasta . $nomeArquivo)) {
                    header("Location: ../vetList?status=erro_imagem");
                    exit();
                }
            }

            $stmt = $conn->prepare("INSERT INTO veterinarians (name, phone, photo) 
                    VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $phone, $nomeArquivo);
            $stmt->execute();
            header("Location: ../vetList?status=criado");
            exit(); 
        }

        
        if (isset($_POST['btnEditar'])) {
            $nomeArquivo = null;

            if (!empty($_FILES['image']['name'])) {
                $extensao = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $nomeArquivo = uniqid('vet_', true) . '.' . $extensao;
                move_uploaded_file($_FILES['image']['tmp_name'], $Pasta . $nomeArquivo);
            }

            $stmt = $conn->prepare("UPDATE veterinarians SET name=?, phone=?, photo=COALESCE(?, photo) WHERE id=?");
            
            $stmt->bind_param("sssi", $name, $phone, $nomeArquivo, $id);
            $stmt->execute();
            header("Location: ../vetList?status=editado");
            exit();
        }
    }

    if(isset($_GET['action'])&& isset($_GET['id'])){
        $action = $_GET['action'];
        $id= intval($_GET['id']);

        
        if($action === 'eliminar'){
            $stmt= $conn->prepare("DELETE FROM veterinarians WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            header("Location: ../vetList?status=apagado");
            exit();
        }
    }

    header("Location: ../vetList");
    exit();

