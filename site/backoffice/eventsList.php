<?php
    if(!$rerun):
        $metaTitle = 'Gestao de Eventos';
        $metaDescription = '';
    else:
        $stmt = $conn->prepare("SELECT e.id, e.name, e.event_date, e.end_date, e.location, e.description, e.event_type, e.status, e.capacity, u.full_name AS organizer_name FROM events e LEFT JOIN users u ON e.organizer_id = u.id ORDER BY e.event_date ASC");
        $stmt->execute();
        $group = $stmt->get_result();

        $eventEdit = null;
        if (isset($_GET['btnEditar'])) {
            $id = (int) $_GET['btnEditar'];
            $res = $conn->query("SELECT * FROM events WHERE id = $id");
            $eventEdit = $res ? $res->fetch_assoc() : null;
        }
?>

        <h1 class="fw-bold fs-2">Gestao de Eventos</h1>
        <div class="d-flex justify-content-end gap-2 mb-3">
            <a href="eventsList?add" class="btn btn-success">+ Criar</a>
        </div>

        <div class="modal fade" id="formModal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa-solid fa-calendar-days me-2"></i>
                            <?= $eventEdit ? "Editar: " . htmlspecialchars($eventEdit['name']) : "Novo Evento"; ?>
                        </h5>
                    </div>

                    <form action="components/action_event.php" method="POST">
                        <div class="modal-body">
                            <?php if ($eventEdit): ?>
                                <input type="hidden" name="id_event" value="<?= (int)$eventEdit['id']; ?>">
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nome do Evento</label>
                                        <input type="text" name="name" class="form-control" value="<?= $eventEdit ? htmlspecialchars($eventEdit['name']) : ''; ?>" required maxlength="100">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Data de Inicio</label>
                                        <input type="datetime-local" name="event_date" class="form-control" value="<?= $eventEdit && !empty($eventEdit['event_date']) ? date('Y-m-d\\TH:i', strtotime($eventEdit['event_date'])) : ''; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Data de Fim</label>
                                        <input type="datetime-local" name="end_date" class="form-control" value="<?= $eventEdit && !empty($eventEdit['end_date']) ? date('Y-m-d\\TH:i', strtotime($eventEdit['end_date'])) : ''; ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Local</label>
                                        <input type="text" name="location" class="form-control" value="<?= $eventEdit ? htmlspecialchars($eventEdit['location']) : ''; ?>" required maxlength="150">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tipo</label>
                                        <select name="event_type" class="form-select" required>
                                            <option value="Caominhada" <?= ($eventEdit && $eventEdit['event_type'] === 'Caominhada') ? 'selected' : ''; ?>>Caominhada</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Estado</label>
                                        <select name="status" class="form-select" required>
                                            <option value="scheduled" <?= ($eventEdit && $eventEdit['status'] === 'scheduled') ? 'selected' : ''; ?>>Agendado</option>
                                            <option value="postponed" <?= ($eventEdit && $eventEdit['status'] === 'postponed') ? 'selected' : ''; ?>>Adiado</option>
                                            <option value="completed" <?= ($eventEdit && $eventEdit['status'] === 'completed') ? 'selected' : ''; ?>>Concluido</option>
                                            <option value="cancelled" <?= ($eventEdit && $eventEdit['status'] === 'cancelled') ? 'selected' : ''; ?>>Cancelado</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Capacidade</label>
                                        <input type="number" name="capacity" class="form-control" min="1" value="<?= $eventEdit && !empty($eventEdit['capacity']) ? (int)$eventEdit['capacity'] : ''; ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Organizador</label>
                                        <select name="organizer_id" class="form-select">
                                            <option value="">Sem organizador</option>
                                            <?php
                                                $users = $conn->query("SELECT id, full_name FROM users ORDER BY full_name ASC");
                                                foreach ($users as $user) {
                                                    $selected = ($eventEdit && (int)$eventEdit['organizer_id'] === (int)$user['id']) ? 'selected' : '';
                                                    echo "<option value='{$user['id']}' {$selected}>" . htmlspecialchars($user['full_name']) . "</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Descricao</label>
                                        <textarea name="description" class="form-control" rows="3" maxlength="1000"><?= $eventEdit ? htmlspecialchars($eventEdit['description']) : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <a href="eventsList" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" name="<?= $eventEdit ? 'btnEditar' : 'btnCriar'; ?>" class="btn btn-success px-4 fw-bold">
                                <i class="fa-solid fa-floppy-disk me-2"></i><?= $eventEdit ? 'Guardar Alteracoes' : 'Adicionar Evento'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <table class="table table-striped align-middle" id="eventTable">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Inicio</th>
                    <th>Fim</th>
                    <th>Local</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Capacidade</th>
                    <th>Organizador</th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($group as $item): ?>
                    <tr>
                        <td><?= (int)$item['id']; ?></td>
                        <td><?= htmlspecialchars($item['name']); ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($item['event_date'])); ?></td>
                        <td><?= !empty($item['end_date']) ? date('d/m/Y H:i', strtotime($item['end_date'])) : '-'; ?></td>
                        <td><?= htmlspecialchars($item['location']); ?></td>
                        <td><?= htmlspecialchars($item['event_type']); ?></td>
                        <td><?= htmlspecialchars($item['status']); ?></td>
                        <td><?= !empty($item['capacity']) ? (int)$item['capacity'] : '-'; ?></td>
                        <td><?= !empty($item['organizer_name']) ? htmlspecialchars($item['organizer_name']) : '-'; ?></td>
                        <td>
                            <a href="components/action_event.php?btnEditar=<?= (int)$item['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="components/action_event.php?btnEliminar=<?= (int)$item['id']; ?>" onclick="return confirm('Apagar este evento?')"><i style="color: #dc3545;" class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <script>
            window.onload = function () {
                <?php if ($eventEdit || isset($_GET['add'])): ?>
                    var meuModal = new bootstrap.Modal(document.getElementById('formModal'));
                    meuModal.show();
                <?php endif; ?>
            };
        </script>
<?php
        $group->free();
        $stmt->close();
    endif;
