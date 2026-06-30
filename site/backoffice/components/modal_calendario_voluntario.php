<?php
$modalMode = isset($editMode) && $editMode;
$shift = $modalMode && isset($volunteerEdit) ? $volunteerEdit : null;

$pref_day = $_GET['day_week'] ?? $_POST['day_week'] ?? ($shift['day_week'] ?? '');
$pref_start = $_GET['start_time'] ?? $_POST['start_time'] ?? ($shift['start_time'] ?? '');
$pref_end = $_GET['end_time'] ?? $_POST['end_time'] ?? ($shift['end_time'] ?? '');
?>
<div class="modal fade" id="formModalCalendarioVoluntario">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-calendar-days me-2"></i>
                    <?= $modalMode ? 'Editar Turno' : 'Novo Turno' ?>
                </h5>
            </div>

            <form action="components/action_calendario_voluntarios.php" method="POST" enctype="multipart/form-data" class="needs-validation custom-validation" novalidate onsubmit="if(!this.checkValidity()) { event.preventDefault(); event.stopPropagation(); } this.classList.add('was-validated');">
                <div class="modal-body">
                    <input type="hidden" name="action" value="<?= $modalMode ? 'edit_shift' : 'add_shift' ?>">
                    <?php if ($modalMode): ?>
                        <input type="hidden" name="shift_id" value="<?= (int)($shift['shift_id'] ?? 0) ?>">
                        <input type="hidden" name="user_id" value="<?= (int)($shift['user_id'] ?? 0) ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label" for="volunteer_name">Nome do Voluntário</label>
                        <input type="text" id="volunteer_name" class="form-control" value="<?= htmlspecialchars($shift['volunteer_name'] ?? ($_POST['volunteer_name'] ?? '')) ?>" disabled>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="day_week">Dia da Semana <span class="text-danger">*</span></label>
                            <select name="day_week" id="day_week" class="form-select">
                                <option value="">Selecione um dia</option>
                                <option value="Segunda" <?= $pref_day === 'Segunda' || $pref_day === 'Segunda-feira' ? 'selected' : '' ?>>Segunda</option>
                                <option value="Terça" <?= $pref_day === 'Terça' || $pref_day === 'Terça-feira' ? 'selected' : '' ?>>Terça</option>
                                <option value="Quarta" <?= $pref_day === 'Quarta' || $pref_day === 'Quarta-feira' ? 'selected' : '' ?>>Quarta</option>
                                <option value="Quinta" <?= $pref_day === 'Quinta' || $pref_day === 'Quinta-feira' ? 'selected' : '' ?>>Quinta</option>
                                <option value="Sexta" <?= $pref_day === 'Sexta' || $pref_day === 'Sexta-feira' ? 'selected' : '' ?>>Sexta</option>
                                <option value="Sábado" <?= $pref_day === 'Sábado' ? 'selected' : '' ?>>Sábado</option>
                                <option value="Domingo" <?= $pref_day === 'Domingo' ? 'selected' : '' ?>>Domingo</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="start_time">Hora de Início <span class="text-danger">*</span></label>
                            <input type="time" name="start_time" id="start_time" class="form-control" value="<?= htmlspecialchars($pref_start) ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="end_time">Hora de Fim <span class="text-danger">*</span></label>
                            <input type="time" name="end_time" id="end_time" class="form-control" value="<?= htmlspecialchars($pref_end) ?>">
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <a href="calendario_voluntarios" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success px-4 fw-bold">
                        <?= $modalMode ? 'Guardar Alterações' : 'Adicionar Turno' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>