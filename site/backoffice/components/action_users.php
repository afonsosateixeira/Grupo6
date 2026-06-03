<?php
    require_once '../../db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $actionId = $_POST['id'] ?? null;
        $actionName = trim($_POST['name'] ?? null);
        $actionEmail = trim($_POST['email'] ?? null);
        $actionPass = trim($_POST['pass'] ?? null);
        $actionPhone = trim($_POST['phone'] ?? null);
        $actionLocal = trim($_POST['local'] ?? '');
        $actionStreet = trim($_POST['street'] ?? '');
        $actionCp = trim($_POST['cp'] ?? '');
        $actionRole = trim($_POST['role'] ?? null);

        if(isset($_POST['btnCriar'])) {
            if($actionName != null && $actionEmail != null && $actionPass != null && $actionPhone != null && $actionRole != null){
                $stmt=$conn->prepare("INSERT INTO users (full_name, email, password, phone, local, street, cp, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss",$actionName, $actionEmail, $actionPass, $actionPhone, $actionLocal, $actionStreet, $actionCp, $actionRole );
                $stmt->execute();
                header("Location: ../user_list?status=criado");
            } else
                header("Location: ../user_list?status=erro_validacao");
            exit();
        }

        if(isset($_POST['btnEditar'])) {
            if($actionId != null && $actionName != null && $actionEmail != null && $actionPhone != null && $actionRole != null){
                if($actionPass != null){
                    $actionPass = hash('sha512', $actionPass);
                    $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, password=?, phone=?, local=?, street=?, cp=?, role=? WHERE id=?");
                    $stmt->bind_param("ssssssssi", $actionName, $actionEmail, $actionPass, $actionPhone, $actionLocal, $actionStreet, $actionCp, $actionRole, $actionId);
                } else {
                    $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, phone=?, local=?, street=?, cp=?, role=? WHERE id=?");
                    $stmt->bind_param("sssssssi", $actionName, $actionEmail, $actionPhone, $actionLocal, $actionStreet, $actionCp, $actionRole, $actionId);
                }
                $stmt->execute();
                header("Location: ../user_list?status=editado");
            } else
                header("Location: ../user_list?status=erro_validacao");
            exit();
        }
    }

    header("Location: ../user_list");
    exit();