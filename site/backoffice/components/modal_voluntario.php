<?php
    $modalMode = isset($editMode) && $editMode;
    $volunteer = $modalMode && isset($volunteerEdit) ? $volunteerEdit : null;
?>
<div class="modal fade" id="formModalVoluntario">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-hands-helping me-2"></i>
                    <?= $modalMode ? 'Editar Voluntário' : 'Novo Voluntário' ?>
                </h5>
            </div>

            <form method="POST" id="volunteerForm" action="<?= $modalMode ? 'components/action_voluntario.php' : '' ?>">
                <div class="modal-body">
                    <input type="hidden" name="action" value="<?= $modalMode ? 'edit_volunteer' : 'add_volunteer' ?>">
                    <?php if ($modalMode): ?>
                        <input type="hidden" name="shift_id" value="<?= (int)$volunteer['shift_id'] ?>">
                        <input type="hidden" name="user_id" value="<?= (int)$volunteer['user_id'] ?>">
                    <?php endif; ?>

                    <?php if ($modalMode): ?>
                        <div class="mb-3">
                            <label class="form-label" for="full_name">Nome do Voluntário</label>
                            <input type="text" name="full_name" id="full_name" class="form-control"
                                value="<?= htmlspecialchars($volunteer['volunteer_name'] ?? '') ?>" placeholder="Nome completo" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="phone">Telemóvel</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                value="<?= htmlspecialchars($volunteer['phone'] ?? '') ?>" placeholder="Telemóvel" required>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="<?= htmlspecialchars($volunteer['email'] ?? ($_POST['email'] ?? '')) ?>"
                            placeholder="email@exemplo.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="localidade">Localidade</label>
                        <input type="text" name="localidade" id="localidade" class="form-control"
                            value="<?= htmlspecialchars($volunteer['city'] ?? ($_POST['localidade'] ?? '')) ?>"
                            placeholder="Ex: Lisboa">
                    </div>

                    <?php if ($modalMode): ?>
                        <div class="mb-3">
                            <label class="form-label" for="status">Status do Turno</label>
                            <select name="status" id="status" class="form-control" required>
                                <?php $currentStatus = $volunteer['status'] ?? 'Pendente'; ?>
                                <option value="Pendente" <?= $currentStatus === 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                                <option value="Aceite" <?= $currentStatus === 'Aceite' ? 'selected' : '' ?>>Aceite</option>
                                <option value="Rejeitado" <?= $currentStatus === 'Rejeitado' ? 'selected' : '' ?>>Rejeitado</option>
                            </select>
                        </div>
                    <?php else: ?>
                        <h6 class="text-info mb-3 mt-4">Horário de Voluntariado</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="day_week">Dia da Semana</label>
                                <select name="day_week" id="day_week" class="form-control" required>
                                    <option value="">Selecione um dia</option>
                                    <option value="Segunda" <?= (isset($_POST['day_week']) && $_POST['day_week'] === 'Segunda') ? 'selected' : '' ?>>Segunda</option>
                                    <option value="Terça" <?= (isset($_POST['day_week']) && $_POST['day_week'] === 'Terça') ? 'selected' : '' ?>>Terça</option>
                                    <option value="Quarta" <?= (isset($_POST['day_week']) && $_POST['day_week'] === 'Quarta') ? 'selected' : '' ?>>Quarta</option>
                                    <option value="Quinta" <?= (isset($_POST['day_week']) && $_POST['day_week'] === 'Quinta') ? 'selected' : '' ?>>Quinta</option>
                                    <option value="Sexta" <?= (isset($_POST['day_week']) && $_POST['day_week'] === 'Sexta') ? 'selected' : '' ?>>Sexta</option>
                                    <option value="Sábado" <?= (isset($_POST['day_week']) && $_POST['day_week'] === 'Sábado') ? 'selected' : '' ?>>Sábado</option>
                                    <option value="Domingo" <?= (isset($_POST['day_week']) && $_POST['day_week'] === 'Domingo') ? 'selected' : '' ?>>Domingo</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="start_time">Hora de Início *</label>
                                <input type="time" name="start_time" id="start_time" class="form-control" value="<?= htmlspecialchars($_POST['start_time'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="end_time">Hora de Fim *</label>
                                <input type="time" name="end_time" id="end_time" class="form-control" value="<?= htmlspecialchars($_POST['end_time'] ?? '') ?>" required>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer bg-light">
                    <a href="listagemvoluntarios" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success px-4 fw-bold">
                        <?= $modalMode ? 'Guardar Alterações' : 'Adicionar Voluntário' ?>
                    </button>
                </div>
                <?= isset($responseError) ? $responseError : '' ?>
            </form>
        </div>
    </div>
</div>
