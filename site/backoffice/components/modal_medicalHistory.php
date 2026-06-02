<div class="modal fade" id="formModalHistory">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-paw me-2"></i>
                    <?= $historyEdit ? "Editar: " . $historyEdit['id'] : "Novo Histórico Médico"; ?>
                </h5>
            </div>

            <form action="components/action_medicalHistory.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php if ($historyEdit): ?>
                        <input type="hidden" name="id_history" value="<?= $historyEdit['id']; ?>">
                    <?php endif; ?>

                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Diagnóstico</label>
                            <input type="text" name="diagnosis" class="form-control" placeholder="Ex: Diabetes"
                                value="<?= $historyEdit ? $historyEdit['diagnosis'] : ''; ?>" required maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Peso:</label>   
                            <input type="text" name="weight" class="form-control" placeholder="Ex: 10.5"
                                value="<?= $historyEdit ? $historyEdit['weight'] : ''; ?>" required maxlength="10">
                        </div>
                        <div class="modal-footer bg-light">
                            <a href="medicalHistory" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" name="<?= $historyEdit ? 'btnEditar' : 'btnCriar'; ?>"
                                class="btn btn-success px-4 fw-bold">
                                <i class="fa-solid fa-floppy-disk me-2"></i> <?= $historyEdit ? 'Guardar Alterações' : 'Adicionar Histórico'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>