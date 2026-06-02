<?php
    require_once '../../db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'add_volunteer') {
            $email = strtolower(trim($_POST['email'] ?? ''));
            $localidade = trim($_POST['localidade'] ?? '');
            $day_week = trim($_POST['day_week'] ?? '');
            $start_time = trim($_POST['start_time'] ?? '');
            $end_time = trim($_POST['end_time'] ?? '');

            $errors = [];
            $validDays = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];

            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'email';
            }
            if (!in_array($day_week, $validDays, true)) {
                $errors[] = 'day_week';
            }

            $start = DateTime::createFromFormat('H:i', $start_time);
            $end = DateTime::createFromFormat('H:i', $end_time);
            if (!$start || $start->format('H:i') !== $start_time) {
                $errors[] = 'start_time';
            }
            if (!$end || $end->format('H:i') !== $end_time) {
                $errors[] = 'end_time';
            }
            if ($start && $end && $end <= $start) {
                $errors[] = 'time_order';
            }

            if (!empty($errors)) {
                header('Location: ../listagemvoluntarios?status=erro_validacao');
                exit();
            }

            $stmt = $conn->prepare('SELECT id FROM users WHERE LOWER(email) = LOWER(?)');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $user_result = $stmt->get_result();
            $stmt->close();

            if ($user_result && $user_result->num_rows > 0) {
                $user = $user_result->fetch_assoc();
                $user_id = $user['id'];

                if ($localidade !== '') {
                    $stmt_local = $conn->prepare('UPDATE users SET local = ? WHERE id = ?');
                    $stmt_local->bind_param('si', $localidade, $user_id);
                    $stmt_local->execute();
                    $stmt_local->close();
                }

                $stmt = $conn->prepare('SELECT id FROM volunteer_profiles WHERE user_id = ?');
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $vol_check = $stmt->get_result();
                $stmt->close();

                if ($vol_check && $vol_check->num_rows > 0) {
                    $volunteer = $vol_check->fetch_assoc();
                    $volunteer_id = $volunteer['id'];
                } else {
                    $stmt = $conn->prepare('INSERT INTO volunteer_profiles(user_id) VALUES(?)');
                    $stmt->bind_param('i', $user_id);
                    $stmt->execute();
                    $volunteer_id = $stmt->insert_id;
                    $stmt->close();
                }

                $stmt = $conn->prepare('INSERT INTO volunteer_shifts(volunteer_id, day_week, start_time, end_time) VALUES(?, ?, ?, ?)');
                $stmt->bind_param('isss', $volunteer_id, $day_week, $start_time, $end_time);
                if ($stmt->execute()) {
                    $stmt->close();
                    header('Location: ../listagemvoluntarios?status=criado');
                    exit();
                }
                $stmt->close();
            }

            header('Location: ../listagemvoluntarios?status=erro_imagem');
            exit();
        }

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
