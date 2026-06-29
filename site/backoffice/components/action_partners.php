<?php
    require_once '../../db.php';
    $folder = "../../assets/img/partners/";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $actionId = $_POST['id'] ?? null;
        $actionCompanyName = trim($_POST['company_name'] ?? null);
        $actionContactPerson = trim($_POST['contact_person'] ?? null);
        $actionPhone = trim($_POST['phone'] ?? null);
        $actionEmail = trim($_POST['email'] ?? null);

        if (isset($_POST['btnCriar'])) {
            $file = "";

            if (!empty($_FILES['image']['name'])) {
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file = uniqid('partner_', true) . '.' . $extension;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $folder . $file)) {
                    header("Location: ../partners?status=erro_imagem");
                    exit();
                }
            }

            if (!empty($actionCompanyName) && !empty($actionContactPerson) && !empty($actionPhone)) {
                $stmt = $conn->prepare("INSERT INTO partners (company_name, contact_person, phone, email, photo) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $actionCompanyName, $actionContactPerson, $actionPhone, $actionEmail, $file);
                $stmt->execute();
                $stmt->close();
                header("Location: ../partners?status=criado");
            } else {
                header("Location: ../partners?status=erro_validacao");
            }
            exit();
        }

        if (isset($_POST['btnEditar'])) {
            $file = null;

            if (!empty($_FILES['image']['name'])) {
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file = uniqid('partner_', true) . '.' . $extension;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $folder . $file)) {
                    header("Location: ../partners?status=erro_imagem");
                    exit();
                }
            }

            if (!empty($actionId) && !empty($actionCompanyName) && !empty($actionContactPerson) && !empty($actionPhone)) {
                if ($file != null) {
                    $stmt = $conn->prepare("UPDATE partners SET company_name=?, contact_person=?, phone=?, email=?, photo=? WHERE id=?");
                    $stmt->bind_param("sssssi", $actionCompanyName, $actionContactPerson, $actionPhone, $actionEmail, $file, $actionId);
                } else {
                    $stmt = $conn->prepare("UPDATE partners SET company_name=?, contact_person=?, phone=?, email=? WHERE id=?");
                    $stmt->bind_param("ssssi", $actionCompanyName, $actionContactPerson, $actionPhone, $actionEmail, $actionId);
                }
                $stmt->execute();
                $stmt->close();
                header("Location: ../partners?status=editado");
            } else {
                header("Location: ../partners?status=erro_validacao");
            }
            exit();
        }
    }

    header("Location: ../partners");
    exit();
?>