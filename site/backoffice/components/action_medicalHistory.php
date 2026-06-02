<?php
    require_once '../../db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $id = $_POST['id_history'];
        $diagnosis = trim($_POST['diagnosis'] ?? '');
        $weight = (float)($_POST['weight'] ?? 0);

        
        if (isset($_POST['btnCriar'])) {            
                $stmt=$conn->prepare("INSERT INTO medical_history (diagnosis, weight) 
                        VALUES (?, ?)");
                $stmt->bind_param("ss", $diagnosis, $weight);
                $stmt->execute();
                header("Location: ../medicalHistory?status=criado");
                exit(); 
        }

        
        if (isset($_POST['btnEditar'])) {            
            $nomeArquivo = null;

            $stmt = $conn->prepare("UPDATE medical_history SET diagnosis=?, weight=? WHERE id=?");
            
            $stmt->bind_param("ssi", $diagnosis, $weight, $id);
            $stmt->execute();
            header("Location: ../medicalHistory?status=editado");
            exit();
        }
    }

    if(isset($_GET['action'])&& isset($_GET['id'])){
        $action = $_GET['action'];
        $id= intval($_GET['id']);

        
        if($action === 'eliminar'){
            $stmt= $conn->prepare("DELETE FROM medical_history WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            header("Location: ../medicalHistory?status=apagado");
            exit();
        }
    }

    header("Location: ../medicalHistory");
    exit();