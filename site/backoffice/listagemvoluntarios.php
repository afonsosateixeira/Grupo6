<?php
if (!$rerun):
    $metaTitle = 'Listagem Voluntários';
    $metaDescription = 'Listar Voluntários';
else:
    $volunteerEdit = null;
    $editMode = false;

    if (isset($_GET['editar']) && is_numeric($_GET['editar'])) {
        $editId = (int) $_GET['editar'];
        $stmt = $conn->prepare('SELECT vs.id AS shift_id, vs.day_week, vs.start_time, vs.end_time, vs.status, u.id AS user_id, u.full_name AS volunteer_name, u.email, u.phone, u.local AS city FROM volunteer_shifts vs JOIN volunteer_profiles vp ON vs.volunteer_id = vp.id JOIN users u ON vp.user_id = u.id WHERE vs.id = ?');
        $stmt->bind_param('i', $editId);
        $stmt->execute();
        $volunteerEdit = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if ($volunteerEdit) {
            $editMode = true;
        }
    }


    if (isset($_GET['action']) && isset($_GET['id'])) {
        $id_turno = intval($_GET['id']);
        $acao = $_GET['action'];
        $novo_status = '';
        $deletar = false;

        if ($acao === 'aceitar') {
            $novo_status = 'Aceite';
        } elseif ($acao === 'rejeitar') {
            $novo_status = 'Rejeitado';
        } elseif ($acao === 'apagar') {
            $deletar = true;
        }

        if ($deletar) {
            $stmt_delete = $conn->prepare("DELETE FROM volunteer_shifts WHERE id = ?");
            $stmt_delete->bind_param("i", $id_turno);
            $stmt_delete->execute();
            $stmt_delete->close();

            $url_limpa = strtok($_SERVER['REQUEST_URI'], '?');
            echo '<meta http-equiv="refresh" content="0;url=' . $url_limpa . '?status=apagado">';
            exit();
        }

        if (!empty($novo_status)) {
            $stmt_status = $conn->prepare("UPDATE volunteer_shifts SET status = ? WHERE id = ?");
            $stmt_status->bind_param("si", $novo_status, $id_turno);
            $stmt_status->execute();
            $stmt_status->close();

            # Código adicional para a funcionalidade de notificações (Rúben)
            $verify = $conn->query("SELECT day_week, start_time, end_time FROM volunteer_shifts WHERE id = $id_turno")->fetch_row();
            $verifyDay = $verify[0];
            $verifyStart = $verify[1];
            $verifyEnd = $verify[2];
            $colorNotif = ($novo_status == 'Aceite') ? 'success' : 'danger';
            $dayNotif = 'O seu turno de '.$verifyDay.'-feira das '.$verifyStart.' às '.$verifyEnd.' ficou '.$novo_status;
            $shiftNotif = $id_turno;
            $verifyId = $conn->query("SELECT vp.user_id FROM volunteer_profiles vp JOIN volunteer_shifts vs ON vp.id = vs.volunteer_id WHERE vs.id = $id_turno")->fetch_row()[0];
            $editNotif = $conn->prepare("INSERT INTO notifications(user, type, title, color, shift) VALUES(?, 'shift', ?, ?, ?)
                ON DUPLICATE KEY UPDATE title = ?, color = ?, status = 'not read', date = current_timestamp");
            $editNotif->bind_param("ississ", $verifyId, $dayNotif, $colorNotif, $shiftNotif, $dayNotif, $colorNotif);
            $editNotif->execute();
            $editNotif->close();

            $url_limpa = strtok($_SERVER['REQUEST_URI'], '?');
            echo '<meta http-equiv="refresh" content="0;url=' . $url_limpa . '?status=status_alterado">';
            exit();
        }
    }

    $sql = "SELECT * FROM vw_volunteer_full_schedule";
    $lista = $conn->query($sql);
?>
    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Voluntários</h1>
        <div class="d-flex justify-content-end gap-2 mb-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formModalVoluntario">+ Criar</button>
        </div>

        <?php include 'components/modal_voluntario.php'; ?>

        <table class="table table-striped table-hover" id="volunteerTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telemóvel</th>
                    <th>Localidade</th>
                    <th>Horário</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($voluntario = $lista->fetch_assoc()): ?>
                    <?php
                    $status = trim($voluntario['status'] ?? '');
                    $status = $status === '' ? 'Pendente' : $status;
                    $statusClass = $status === 'Aceite'
                        ? 'bg-success'
                        : ($status === 'Rejeitado' ? 'bg-danger' : 'bg-secondary');
                    $statusActions = $status === 'Pendente';
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($voluntario['shift_id']) ?></td>
                        <td><?= htmlspecialchars($voluntario['volunteer_name']) ?></td>
                        <td><?= htmlspecialchars($voluntario['phone']) ?></td>
                        <td><?= htmlspecialchars($voluntario['city']) ?></td>
                        <td>
                            <?= htmlspecialchars($voluntario['day_week']) ?> –
                            <?= date('H:i', strtotime($voluntario['start_time'])) ?> até
                            <?= date('H:i', strtotime($voluntario['end_time'])) ?>
                        </td>
                        <td>
                            <span class="badge <?= $statusClass ?> me-2 fw-bold"><?= htmlspecialchars($status) ?></span>
                            <?php if ($statusActions): ?>
                                <a href="?action=aceitar&id=<?= $voluntario['shift_id'] ?>">
                                    <i style="color: #0dc20d;" class="fa fa-check-square"></i>
                                </a>
                                <a href="?action=rejeitar&id=<?= $voluntario['shift_id'] ?>">
                                    <i style="color: #dc3545;" class="fa fa-window-close"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?editar=<?= $voluntario['shift_id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="?action=apagar&id=<?= $voluntario['shift_id'] ?>"
                                onclick="return confirm('Tem a certeza que quer apagar este voluntário??')">
                                <i style="color: #dc3545;" class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <script>
            window.onload = function() {
                <?php if (isset($responseError) || (isset($editMode) && $editMode)): ?>
                    var meuModal = new bootstrap.Modal(document.getElementById('formModalVoluntario'));
                    meuModal.show();
                <?php endif; ?>
            };
        </script>
    </section>
<?php
endif;
?>