<?php
    require_once '../../db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $id = $_POST['id_appointment'];
        $animal = trim($_POST['animal'] ?? '');
        $name_animal = trim($_POST['name_animal'] ?? '');
        $age_animal = (int)($_POST['age_animal'] ?? 0);
        $breed_animal =trim($_POST['breed_animal'] ?? '');
        $vet_id = (int)($_POST['vet_id'] ?? 0);
        $date= $_POST['date'];
		$horary = $_POST['horary'];	
		$appointment_date= $date. ' ' . $horary . ':00';
        $status = trim($_POST['status'] ?? '');

        
        if (isset($_POST['btnCriar'])) {            
                $stmt=$conn->prepare("INSERT INTO appointments (animal, name_animal, age_animal, breed_animal, vet_id, appointment_date, status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssissss", $animal, $name_animal, $age_animal, $breed_animal, $vet_id, $appointment_date, $status);
                $stmt->execute();
                header("Location: ../appointmentList?status=criado");
                exit(); 
        }

        
        if (isset($_POST['btnEditar'])) {            
            $nomeArquivo = null;

            $stmt = $conn->prepare("UPDATE appointments SET animal=?, name_animal=?, age_animal=?, breed_animal=?, vet_id=?, appointment_date=?, status=? WHERE id=?");
            
            $stmt->bind_param("ssissssi", $animal, $name_animal, $age_animal, $breed_animal, $vet_id, $appointment_date, $status, $id);
            $stmt->execute();
            header("Location: ../appointmentList?status=editado");
            exit();
        }
    }

    if(isset($_GET['action'])&& isset($_GET['id'])){
        $action = $_GET['action'];
        $id= intval($_GET['id']);

        
        if($action === 'eliminar'){
            $stmt= $conn->prepare("DELETE FROM appointments WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            header("Location: ../appointmentList?status=apagado");
            exit();
        }
    }

    header("Location: ../appointmentList");
    exit();