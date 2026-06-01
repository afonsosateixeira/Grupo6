<?php
    require_once '../../db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'edit_volunteer') {
            $shift_id = (int)($_POST['shift_id'] ?? 0);
            $user_id = (int)($_POST['user_id'] ?? 0);
            $full_name = trim($_POST['full_name'] ?? '');
            $email = strtolower(trim($_POST['email'] ?? ''));
            $phone = trim($_POST['phone'] ?? '');
            $localidade = trim($_POST['localidade'] ?? '');
            $status = trim($_POST['status'] ?? 'Pendente');
            $allowedStatuses = ['Pendente', 'Aceite', 'Rejeitado'];
            if (!in_array($status, $allowedStatuses, true)) {
                $status = 'Pendente';
            }

            if ($user_id > 0 && $shift_id > 0) {
                $stmt = $conn->prepare('UPDATE users SET full_name = ?, email = ?, phone = ?, local = ? WHERE id = ?');
                $stmt->bind_param('ssssi', $full_name, $email, $phone, $localidade, $user_id);
                $success = $stmt->execute();
                $stmt->close();

                if ($success) {
                    $stmt_status = $conn->prepare('UPDATE volunteer_shifts SET status = ? WHERE id = ?');
                    $stmt_status->bind_param('si', $status, $shift_id);
                    $success = $stmt_status->execute();
                    $stmt_status->close();
                }

                if ($success) {
                    header('Location: ../listagemvoluntarios?status=editado');
                    exit();
                }
            }

            header('Location: ../listagemvoluntarios?status=erro_edit&editar=' . intval($shift_id));
            exit();
        }
    }

    header('Location: ../listagemvoluntarios');
    exit();
