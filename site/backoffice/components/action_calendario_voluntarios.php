<?php
require_once '../../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../calendario_voluntarios');
    exit();
}

$action = $_POST['action'] ?? '';

if ($action === 'edit_shift') {
    $shift_id = (int)($_POST['shift_id'] ?? 0);
    $day_week = trim($_POST['day_week'] ?? '');
    $start_time = trim($_POST['start_time'] ?? '');
    $end_time = trim($_POST['end_time'] ?? '');

    $validDays = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira'];

    $errors = [];
    if ($shift_id <= 0) {
        $errors[] = 'id';
    }
    if (!in_array($day_week, $validDays, true)) {
        $errors[] = 'day_week';
    }

    $start = DateTime::createFromFormat('H:i', $start_time);
    $end = DateTime::createFromFormat('H:i', $end_time);

    if (!empty($errors)) {
        header('Location: ../calendario_voluntarios?status=erro_validacao&editar=' . intval($shift_id));
        exit();
    }

    $stmt = $conn->prepare('UPDATE volunteer_shifts SET day_week = ?, start_time = ?, end_time = ? WHERE id = ?');
    $stmt->bind_param('sssi', $day_week, $start_time, $end_time, $shift_id);
    $success = $stmt->execute();
    $stmt->close();

    if ($success) {

        # Código adicional para a funcionalidade de notificações (Rúben)
        $dayNotif = 'O seu turno foi alterado para '.$day_week.'-feira das '.$start_time.' às '.$end_time;
        $shiftNotif = $shift_id;
        $verifyId = $conn->query("SELECT vp.user_id FROM volunteer_profiles vp JOIN volunteer_shifts vs ON vp.id = vs.volunteer_id WHERE vs.id = $shift_id")->fetch_row()[0];
        $editNotif = $conn->prepare("INSERT INTO notifications(user, type, title, color, shift) VALUES(?, 'shift', ?, 'warning', ?)
            ON DUPLICATE KEY UPDATE title = ?, color = 'warning', status = 'not read', date = current_timestamp");
        $editNotif->bind_param("isis", $verifyId, $dayNotif, $shiftNotif, $dayNotif);
        $editNotif->execute();
        $editNotif->close();

        header('Location: ../calendario_voluntarios?status=editado');
        exit();
    }

    header('Location: ../calendario_voluntarios?status=erro_edit&editar=' . intval($shift_id));
    exit();
}

header('Location: ../calendario_voluntarios');
exit();
