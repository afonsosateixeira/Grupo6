<?php
    require_once '../../db.php';
    $folder = "../../assets/img/lost/";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $actionId = $_POST['id'] ?? null;
        $actionUserId = $_POST['user_id'] ?? null;
        $actionName = trim($_POST['name'] ?? null);
        $actionSeen = trim($_POST['seen'] ?? null);
        $actionPhone = trim($_POST['phone'] ?? null);
        $actionLocal = trim($_POST['local'] ?? null);
        $actionFound = trim($_POST['found'] ?? 'No');

        if (isset($_POST['btnCriar'])) {
            $file = "";

            if (!empty($_FILES['image']['name'])) {
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file = uniqid('lost_', true) . '.' . $extension;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $folder . $file)) {
                    header("Location: ../missing_animals?status=erro_imagem");
                    exit();
                }
            }

            if($actionUserId != null && $actionName != null && $actionSeen != null && $actionPhone != null && $actionLocal != null){
                $stmt=$conn->prepare("INSERT INTO lost_animals (user_id, animal_name, last_seen_date, contact_phone, location, photo) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("isssss",$actionUserId, $actionName, $actionSeen, $actionPhone, $actionLocal, $file);
                $stmt->execute();
                header("Location: ../missing_animals?status=criado");
            } else
                header("Location: ../missing_animals?status=erro_validacao");
            exit();
        }

        if (isset($_POST['btnEditar'])) {
            $file = null;

            if (!empty($_FILES['image']['name'])) {
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file = uniqid('lost_', true) . '.' . $extension;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $folder . $file)) {
                    header("Location: ../missing_animals?status=erro_imagem");
                    exit();
                }
            }

            if($actionId != null && $actionUserId != null && $actionName != null && $actionSeen != null && $actionPhone != null && $actionLocal != null){
                if($file != null){
                    $stmt = $conn->prepare("UPDATE lost_animals SET user_id=?, animal_name=?, last_seen_date=?, contact_phone=?, location=?, photo=?, found=? WHERE id=?");
                    $stmt->bind_param("issssssi", $actionUserId, $actionName, $actionSeen, $actionPhone, $actionLocal, $file, $actionFound, $actionId);
                } else {
                    $stmt = $conn->prepare("UPDATE lost_animals SET user_id=?, animal_name=?, last_seen_date=?, contact_phone=?, location=?, found=? WHERE id=?");
                    $stmt->bind_param("isssssi", $actionUserId, $actionName, $actionSeen, $actionPhone, $actionLocal, $actionFound, $actionId);
                }
                $stmt->execute();
                header("Location: ../missing_animals?status=editado");
            } else
                header("Location: ../missing_animals?status=erro_validacao");
            exit();
        }
    }

    header("Location: ../missing_animals");
    exit();