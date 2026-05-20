<?php
    require_once '../../db.php';

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
        }

        # Processo de eliminação do processo de adoção
        if($action === "eliminar"){
            $stmt= $conn->prepare("DELETE FROM adoption_processes WHERE id= ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
    }

    header("Location: ../adoptionProcess.php");
    exit();
?>