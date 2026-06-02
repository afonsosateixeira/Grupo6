<div class="modal fade" id="formModalvet">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-paw me-2"></i>
                    <?= $vetEdit ? "Editar: " . $vetEdit['name'] : "Novo Veterinário"; ?>
                </h5>
            </div>

            <form action="components/action_vet.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php if ($vetEdit): ?>
                        <input type="hidden" name="id_vet" value="<?= $vetEdit['id']; ?>">
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nome do veterinário</label>
                                <input type="text" name="name" class="form-control" placeholder="Ex: Dr. Silva"
                                    value="<?= $vetEdit ? $vetEdit['name'] : ''; ?>" required maxlength="50">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Telefone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Ex: 912345678"
                                    value="<?= $vetEdit ? $vetEdit['phone'] : ''; ?>" required maxlength="20">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Fotografia</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>

                        </div>
                        <div class="modal-footer bg-light">
                            <a href="vetList" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" name="<?= $vetEdit ? 'btnEditar' : 'btnCriar'; ?>"
                                class="btn btn-success px-4 fw-bold">
                                <i class="fa-solid fa-floppy-disk me-2"></i> <?= $vetEdit ? 'Guardar Alterações' : 'Adicionar Veterinário'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>