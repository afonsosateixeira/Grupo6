<?php
    require_once '../../db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name'] ?? '');
        $eventDate = trim($_POST['event_date'] ?? '');
        $endDate = trim($_POST['end_date'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $eventType = trim($_POST['event_type'] ?? 'Caominhada');
        $status = trim($_POST['status'] ?? 'scheduled');
        $capacity = trim($_POST['capacity'] ?? '');
        $organizerId = trim($_POST['organizer_id'] ?? '');

        $nameSafe = $conn->real_escape_string($name);
        $eventDateSafe = $conn->real_escape_string(str_replace('T', ' ', $eventDate) . ':00');
        $locationSafe = $conn->real_escape_string($location);
        $descriptionSafe = $conn->real_escape_string($description);
        $eventTypeSafe = $conn->real_escape_string($eventType);
        $statusSafe = $conn->real_escape_string($status);

        $endDateSql = empty($endDate) ? 'NULL' : "'" . $conn->real_escape_string(str_replace('T', ' ', $endDate) . ':00') . "'";
        $capacitySql = ($capacity === '' ? 'NULL' : (int)$capacity);
        $organizerSql = ($organizerId === '' ? 'NULL' : (int)$organizerId);

        if (isset($_POST['btnCriar'])) {
            $sql = "INSERT INTO events (name, event_date, end_date, location, description, event_type, status, capacity, organizer_id)
                    VALUES ('$nameSafe', '$eventDateSafe', $endDateSql, '$locationSafe', '$descriptionSafe', '$eventTypeSafe', '$statusSafe', $capacitySql, $organizerSql)";
            $conn->query($sql);
            header('Location: ../eventsList?status=criado');
            exit();
        }

        if (isset($_POST['btnEditar'])) {
            $id = (int)($_POST['id_event'] ?? 0);
            $sql = "UPDATE events SET
                    name = '$nameSafe',
                    event_date = '$eventDateSafe',
                    end_date = $endDateSql,
                    location = '$locationSafe',
                    description = '$descriptionSafe',
                    event_type = '$eventTypeSafe',
                    status = '$statusSafe',
                    capacity = $capacitySql,
                    organizer_id = $organizerSql
                    WHERE id = $id";
            $conn->query($sql);
            header('Location: ../eventsList?status=editado');
            exit();
        }
    }

    if (isset($_GET['btnEliminar'])) {
        $id = (int)$_GET['btnEliminar'];
        $conn->query("DELETE FROM events_registrations WHERE event_id = $id");
        $conn->query("DELETE FROM events WHERE id = $id");
        header('Location: ../eventsList?status=apagado');
        exit();
    }

    if (isset($_GET['btnEditar'])) {
        $id = (int)$_GET['btnEditar'];
        header("Location: ../eventsList?btnEditar=$id");
        exit();
    }

    header('Location: ../eventsList');
    exit();
