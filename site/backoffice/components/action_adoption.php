<?php
    require_once '../../db.php';
    require_once '../../components/helpers.php';
    if (session_status() === PHP_SESSION_NONE) session_start();
    $action = $_GET['action'] ?? '';

    #POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = (int)($_POST['id_adoption'] ?? 0);
        $user = (int)($_POST['user_id'] ?? 0);
        $animal = (int)($_POST['animal_id'] ?? 0);
        $note = trim($_POST['notes'] ?? '');

        if (isset($_POST['btnCriar'])) {
            prepareQuery($conn, 'INSERT INTO adoption_processes (user_id, animal_id, notes, status) VALUES (?, ?, ?, "Pendente")', 'iis', $user, $animal, $note);
            redirect("../adoptionProcess?status=criado");
        }
        if (isset($_POST['btnEditar'])) {
            prepareQuery($conn, 'UPDATE adoption_processes SET user_id=?, animal_id=?, notes=? WHERE id=?', 'iisi', $user, $animal, $note, $id);
            redirect("../adoptionProcess?status=editado");
        }
    }

    #GET
    if ($action === 'adotar' && !empty($_GET['id_animal']) && !empty($_SESSION['id_user'])) {    
        $animal_id = (int)$_GET['id_animal'];
        prepareQuery($conn, 'INSERT INTO adoption_processes(user_id, animal_id, status) VALUES(?, ?, "Pendente")', 'ii', $_SESSION['id_user'], $animal_id);
        prepareQuery($conn, "UPDATE animals SET status='Em processo' WHERE id=?", 'i', $animal_id);
        redirect("../../animalDetails?id=$animal_id&status=iniciado");
    }

    if (!empty($_GET['id']) && in_array($action, ['cancelar_processo', 'eliminar', 'mudar_status'])) {    
        $id = (int)$_GET['id'];
        $animal_id = prepareQuery($conn, 'SELECT animal_id FROM adoption_processes WHERE id=?', 'i', $id)->get_result()->fetch_assoc()['animal_id'] ?? 0;
        
        if ($animal_id > 0) {
            
            if ($action === 'mudar_status' && isset($_GET['status'])) {
                $st = $_GET['status'];
                $mapa = ['Aprovado' => 'Adotado', 'Pendente' => 'Em processo', 'Rejeitado' => 'Disponível'];

                if (isset($mapa[$st])) {
                    prepareQuery($conn, "UPDATE adoption_processes SET status=? WHERE id=?", 'si', $st, $id);
                    prepareQuery($conn, "UPDATE animals SET status=? WHERE id=?", 'si', $mapa[$st], $animal_id);

                    if($st === 'Pendente'){
                        prepareQuery($conn, 'UPDATE adoption_processes SET end_date=NULL WHERE id= ?', 'i', $id);
                    }else{
                        prepareQuery($conn, 'UPDATE adoption_processes SET end_date=NOW() WHERE id= ?', 'i', $id);
                    }
                }
                redirect("../adoptionProcess?status=status_alterado");
            } else {
                prepareQuery($conn, "DELETE FROM adoption_processes WHERE id=?", 'i', $id);
                prepareQuery($conn, "UPDATE animals SET status='Disponível' WHERE id=?", 'i', $animal_id);

                redirect($action === 'cancelar_processo' ? "../../animalDetails?id=$animal_id&status=cancelado" : "../adoptionProcess?status=eliminado");
            }
        }
    }
    redirect("../adoptionProcess.php");
    /* todos os processos que se tornarem rejitados ou aprovados, passado 5 dias vão desaparecer da lista de processos, só que os processos rejeitados passado os 5 dias vão ser mesmo deletados da BD e os aprovados vão ser "ocultados" da lista mas vão continar na BD para pormos na tabela de animais adotados o processo dele para ser adotado.

    1-se o status for rejeitado e esitver á mais de 5 dias eliminar o processo da BD
    2-se o status for aprovado e estiver á mais de 5 dias ocultar o processo da lista de processos mas não eliminar da BD
    */
    
?>



