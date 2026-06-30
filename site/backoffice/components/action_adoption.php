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

        if ($user <= 0 || $animal <= 0 || mb_strlen($note) > 500) {
            redirect("../adoptionProcess?status=erro_validacao");
            exit; 
        }

        if (isset($_POST['btnCriar'])) {
            $stmt = prepareQuery($conn, 'INSERT INTO adoption_processes (user_id, animal_id, notes, status) VALUES (?, ?, ?, "Pendente")', 'iis', $user, $animal, $note);

            # Código adicional para a funcionalidade de notificações (Rúben)
            $verifyAdopt = $stmt->insert_id;
            $verifyAnimal = $conn->query("SELECT name FROM animals WHERE id = $animal")->fetch_row()[0];
            $insTitle = 'Foi inscrito para adotar '.$verifyAnimal;
            $insNotif = $conn->prepare("INSERT INTO notifications(user, type, title, color, adoption) VALUES(?, 'adoption', ?, 'warning', ?)");
            $insNotif->bind_param("isi", $user, $insTitle, $verifyAdopt);
            $insNotif->execute();
            $insNotif->close();

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

                    # Código adicional para a funcionalidade de notificações (Rúben)
                    $verify = $conn->query("SELECT name, gender FROM animals WHERE id = $animal_id")->fetch_row();
                    $verifyName = $verify[0];
                    $verifyGender = ($verify[1] == 'Macho') ? 'do' : 'da';
                    $colorNotif = ($st == 'Aprovado') ? 'success' : (($st == 'Rejeitado') ? 'danger' : 'warning');
                    $titleNotif = 'O seu processo de adoção '.$verifyGender.' '.$verifyName.' ficou '.$st;
                    $adoptionNotif = $id;
                    $verifyId = $conn->query("SELECT user_id FROM adoption_processes WHERE id = $id")->fetch_row()[0];
                    $editNotif = $conn->prepare("INSERT INTO notifications(user, type, title, color, adoption) VALUES(?, 'adoption', ?, ?, ?)
                        ON DUPLICATE KEY UPDATE title = ?, color = ?, status = 'not read', date = current_timestamp");
                    $editNotif->bind_param("ississ", $verifyId, $titleNotif, $colorNotif, $adoptionNotif, $titleNotif, $colorNotif);
                    $editNotif->execute();
                    $editNotif->close();

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
?>



