<?php
    // ====================================================================
    // 1. CONFIGURAÇÃO DAS METATAGS
    // ====================================================================
    if(!$rerun):
        $metaTitle = 'Listagem Voluntários';
        $metaDescription = 'Listar Voluntários';
    else:
        // ====================================================================
        // 2. PROCESSAMENTO DO FORMULÁRIO DE ADICIONAR VOLUNTÁRIO
        // ====================================================================
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'add_volunteer') {
                $email = strtolower(trim($_POST['email']));
                $day_week = trim($_POST['day_week']);
                $start_time = trim($_POST['start_time']);
                $end_time = trim($_POST['end_time']);

                $stmt = $conn->prepare('SELECT id FROM users WHERE LOWER(email) = LOWER(?)');
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $user_result = $stmt->get_result();
                $stmt->close();

                if ($user_result && $user_result->num_rows > 0) {
                    $user = $user_result->fetch_assoc();
                    $user_id = $user['id'];

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
                        $response = '<div class="alert alert-success mt-3">Voluntário adicionado com sucesso!</div>';
                    } else {
                        $response = '<div class="alert alert-danger mt-3">Erro ao adicionar turno!</div>';
                    }
                    $stmt->close();
                } else {
                    $response = '<div class="alert alert-danger mt-3">Email não encontrado. Utilize um email existente.</div>';
                }
            }
        }

        // ====================================================================
        // 3. PROCESSAMENTO DA ALTERAÇÃO DE STATUS / APAGAR VOLUNTÁRIO
        // ====================================================================
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
                echo '<meta http-equiv="refresh" content="0;url=' . $url_limpa . '">';
                exit();
            }

            if (!empty($novo_status)) {
                $stmt_status = $conn->prepare("UPDATE volunteer_shifts SET status = ? WHERE id = ?");
                $stmt_status->bind_param("si", $novo_status, $id_turno);
                $stmt_status->execute();
                $stmt_status->close();

                $url_limpa = strtok($_SERVER['REQUEST_URI'], '?');
                echo '<meta http-equiv="refresh" content="0;url=' . $url_limpa . '">';
                exit();
            }
        }

        // ====================================================================
        // 4. CONSULTA DOS DADOS PARA A TABELA
        // ====================================================================
        $sql = "SELECT * FROM vw_volunteer_full_schedule";
        $lista = $conn->query($sql);
?>
    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Voluntários</h1>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Adicionar Novo Voluntário</h5>
            </div>
            <div class="card-body">
                <form method="POST" id="volunteerForm">
                    <input type="hidden" name="action" value="add_volunteer">

                    <div class="mb-3">
                        <label class="form-label" for="email">Email *</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="email@exemplo.com" required>
                    </div>

                    <h6 class="text-info mb-3 mt-4">Horário de Voluntariado</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="day_week">Dia da Semana *</label>
                            <select name="day_week" id="day_week" class="form-control" required>
                                <option value="">Selecione um dia</option>
                                <option value="Segunda">Segunda</option>
                                <option value="Terça">Terça</option>
                                <option value="Quarta">Quarta</option>
                                <option value="Quinta">Quinta</option>
                                <option value="Sexta">Sexta</option>
                                <option value="Sábado">Sábado</option>
                                <option value="Domingo">Domingo</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="start_time">Hora de Início *</label>
                            <input type="time" name="start_time" id="start_time" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="end_time">Hora de Fim *</label>
                            <input type="time" name="end_time" id="end_time" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Adicionar Voluntário</button>
                    <?= isset($response) ? $response : '' ?>
                </form>
            </div>
        </div>

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
                <?php while($voluntario = $lista->fetch_assoc()): ?>
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
                            <a href=""><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="?action=apagar&id=<?= $voluntario['shift_id'] ?>">
                                <i style="color: #dc3545;" class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
<?php
    endif;
?>