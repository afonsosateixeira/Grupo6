<div class="modal fade" id="formModaladopt">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-paw me-2"></i>
                    <?= $adoptEdit ? "Editar Processo" : "Novo Processo"; ?>
                </h5>
            </div>

            <form action="components/action_adoption.php" method="POST" enctype="multipart/form-data" class="needs-validation custom-validation" novalidate onsubmit="if(!this.checkValidity()) { event.preventDefault(); event.stopPropagation(); } this.classList.add('was-validated');">
                
                <div class="modal-body">
                    <?php if ($adoptEdit): ?>
                        <input type="hidden" name="id_adoption" value="<?= $adoptEdit['id']; ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Escolha o adotante <span class="text-danger">*</span></label>
                        <select name="user_id" id="select-user" class="form-select" required>
                            <option value="">Selecione um adotante</option>
                            <?php
                            $user = $conn->query("SELECT id, full_name FROM users");
                            foreach ($user as $usr) {
                                $selected = ($adoptEdit && $adoptEdit['user_id'] == $usr['id']) ? 'selected' : '';
                                echo "<option value='{$usr['id']}' {$selected}>{$usr['full_name']}</option>";
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback fw-bold">Por favor, selecione um adotante da lista.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Escolha um animal <span class="text-danger">*</span></label>
                        <select name="animal_id" id="select-animal" class="form-select" required>
                            <option value="">Selecione um animal</option>
                            <?php
                            $animal = $conn->query("SELECT id, name FROM animals");
                            foreach ($animal as $ani) {
                                $selected = ($adoptEdit && $adoptEdit['animal_id'] == $ani['id']) ? 'selected' : '';
                                echo "<option value='{$ani['id']}' {$selected}>{$ani['name']}</option>";
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback fw-bold">Por favor, selecione um animal.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Notas</label>
                        <textarea name="notes" class="form-control" rows="3" maxlength="500" placeholder="Breve descrição do animal..."><?= $adoptEdit ? htmlspecialchars($adoptEdit['notes']) : ''; ?></textarea>
                        <div class="invalid-feedback fw-bold">As notas não podem exceder os 500 caracteres.</div>
                    </div>

                </div> <div class="modal-footer bg-light">
                    <a href="adoptionProcess" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" name="<?= $adoptEdit ? 'btnEditar' : 'btnCriar'; ?>"
                        class="btn btn-success px-4 fw-bold">
                        <i class="fa-solid fa-floppy-disk me-2"></i> <?= $adoptEdit ? 'Guardar Alterações' : 'Adicionar Processo'; ?>
                    </button>
                </div>
                
            </form>
        </div>
    </div>
</div>