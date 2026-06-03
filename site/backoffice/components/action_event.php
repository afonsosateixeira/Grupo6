<?php
    require_once '../../db.php';

    function failValidation() {
        header('Location: ../eventsList?error=validacao_evento');
        exit();
    }

    function isValidDateTimeLocal($value) {
        if (!is_string($value) || trim($value) === '') {
            return false;
        }

        $dateTime = DateTime::createFromFormat('Y-m-d\\TH:i', $value);
        return $dateTime && $dateTime->format('Y-m-d\\TH:i') === $value;
    }

    function hasOnlyWhitespace($value) {
        return trim((string)$value) === '';
    }

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

        $allowedEventTypes = ['Caominhada', 'Cãominhada', 'Feira de Adoção', 'Workshop', 'Campanha Solidária', 'Sessão de Treino', 'Palestra', 'Visita Escolar', 'Angariação de Fundos'];
        $allowedStatuses = ['scheduled', 'postponed', 'completed', 'cancelled'];

        if (strlen($name) < 3 || strlen($name) > 100 || hasOnlyWhitespace($name)) failValidation();
        if (!isValidDateTimeLocal($eventDate)) failValidation();
        if ($endDate !== '' && !isValidDateTimeLocal($endDate)) failValidation();
        if (strlen($location) < 2 || strlen($location) > 150 || hasOnlyWhitespace($location)) failValidation();
        if (!in_array($eventType, $allowedEventTypes, true)) failValidation();
        if (!in_array($status, $allowedStatuses, true)) failValidation();

        $capacityValue = null;
        if ($capacity !== '') {
            if (!ctype_digit($capacity)) failValidation();

            $capacityValue = (int)$capacity;
            if ($capacityValue < 1 || $capacityValue > 100000) failValidation();
        }

        $organizerValue = null;
        if ($organizerId !== '') {
            if (!ctype_digit($organizerId)) failValidation();

            $organizerValue = (int)$organizerId;
            $stmtOrganizer = $conn->prepare('SELECT id FROM users WHERE id = ? LIMIT 1');
            $stmtOrganizer->bind_param('i', $organizerValue);
            $stmtOrganizer->execute();
            $organizerExists = $stmtOrganizer->get_result()->num_rows > 0;
            $stmtOrganizer->close();

            if (!$organizerExists) failValidation();
        }

        $eventDateDb = str_replace('T', ' ', $eventDate) . ':00';
        $endDateDb = $endDate === '' ? null : str_replace('T', ' ', $endDate) . ':00';

        if ($endDateDb !== null && strtotime($endDateDb) < strtotime($eventDateDb)) failValidation();

        if (isset($_POST['btnCriar'])) {
            $stmtCreate = $conn->prepare('INSERT INTO events (name, event_date, end_date, location, description, event_type, status, capacity, organizer_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmtCreate->bind_param('sssssssii', $name, $eventDateDb, $endDateDb, $location, $description, $eventType, $status, $capacityValue, $organizerValue);
            $stmtCreate->execute();
            $stmtCreate->close();
            header('Location: ../eventsList?status=criado');
            exit();
        }

        if (isset($_POST['btnEditar'])) {
            $id = (int)($_POST['id_event'] ?? 0);
            if ($id <= 0) failValidation();

            $stmtUpdate = $conn->prepare('UPDATE events SET name = ?, event_date = ?, end_date = ?, location = ?, description = ?, event_type = ?, status = ?, capacity = ?, organizer_id = ? WHERE id = ?');
            $stmtUpdate->bind_param('sssssssiii', $name, $eventDateDb, $endDateDb, $location, $description, $eventType, $status, $capacityValue, $organizerValue, $id);
            $stmtUpdate->execute();
            $stmtUpdate->close();
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
