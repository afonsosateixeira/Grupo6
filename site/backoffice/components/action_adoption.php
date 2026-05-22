<?php
    require_once '../../db.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $id = (int)($_POST['id_adoption'] ?? 0);
        $user= (int)($_POST['user_id'] ?? 0);
        $animal= (int)($_POST['animal_id'] ?? 0);
        $note =  trim($_POST['notes'] ?? '');

        if(isset($_POST['btnCriar'])){
            $stmt=$conn->prepare('INSERT INTO adoption_processes (user_id, animal_id, notes) VALUES (?, ?, ?)');
            $stmt->bind_param('iis', $user, $animal, $note);
            $stmt->execute();

            header("location: ../adoptionProcess?status=criado");
            exit();
        }
        
        if(isset($_POST['btnEditar'])){
            $stmt= $conn->prepare('UPDATE adoption_processes SET user_id =?, animal_id=?, notes=? WHERE id=?');
            $stmt->bind_param("iisi", $user, $animal, $note, $id);
            $stmt->execute();

            header("location: ../adoptionProcess?status=editado");
            exit();
        }
    }


    if(isset($_GET['action']) && isset($_GET['id'])){
        $action= $_GET['action'];
        $id= intval($_GET['id']);
        
        # Processo de mudança de status do processo de adoção
        if($action === 'mudar_status' && isset($_GET['status'])){
            $status= $_GET['status'];

            if(in_array($status, ['Pendente', 'Aprovado', 'Rejeitado'])){
                $stmt= $conn->prepare("UPDATE adoption_processes SET status= ? WHERE id=?");
                $stmt->bind_param("si", $status, $id);
                $stmt->execute();
            }

            header("location: ../adoptionProcess?status=status_alterado");
            exit();
        }

        # Processo de eliminação do processo de adoção
        if($action === "eliminar"){
            $stmt= $conn->prepare("DELETE FROM adoption_processes WHERE id= ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            header("location: ../adoptionProcess?status=apagado");
            exit();
        }
    }

    header("Location: ../adoptionProcess.php");
    exit();
?>