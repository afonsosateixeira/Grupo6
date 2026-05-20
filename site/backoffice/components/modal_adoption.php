<div class="modal fade" id="formModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-paw me-2"></i>
                    <?= $adoptEdit ? "Editar Processo" : "Novo Processo"; ?>
                </h5>
            </div>

            <form action="components/action_adoption.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php if ($adoptEdit): ?>
                        <input type="hidden" name="id_adoption" value="<?= $adoptEdit['id']; ?>">
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Escolha o adotante:</label>
                                <select name="specie_id" id="select-especie" class="form-select" required>
                                    <option value="">Selecione um adotante</option>
                                    <?php
                                    $especie = $conn->query("SELECT id, name FROM species");
                                    foreach ($especie as $esp) {
                                    
                                        $selected = ($adoptEdit && $adoptEdit['specie_id'] == $esp['id']) ? 'selected' : '';
                                        echo "<option value='{$esp['id']}' {$selected}>{$esp['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Escolha um animal:</label>
                                <select name="breed_id" id="select-raca" class="form-select">
                                    <option value="">Selecione um animal</option>
                                    <?php
                                    $raca = $conn->query("SELECT id, name FROM breeds");
                                    foreach ($raca as $rac) {
                                        $selected = ($adoptEdit && $adoptEdit['breed_id'] == $rac['id']) ? 'selected' : '';
                                        echo "<option value='{$rac['id']}' {$selected}>{$rac['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Notas</label>
                                <textarea name="description" class="form-control" rows="3" maxlength="500" placeholder="Breve descrição do animal..."><?= $adoptEdit ? $adoptEdit['description'] : ''; ?></textarea>
                            </div>

                        </div>
                        <div class="modal-footer bg-light">
                            <a href="adoptionProcess" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" name="<?= $adoptEdit ? 'btnEditar' : 'btnCriar'; ?>"
                                class="btn btn-success px-4 fw-bold">
                                <i class="fa-solid fa-floppy-disk me-2"></i> <?= $adoptEdit ? 'Guardar Alterações' : 'Adicionar Processo'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>