<div class="modal fade" id="formModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-paw me-2"></i>
                    <?= $edit ? "Editar: " . $edit['animal_name'] : "Novo Processo de Animal Perdido"; ?>
                </h5>
            </div>

            <form action="components/action_missing.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php
                        if ($edit){
                    ?>
                            <input type="hidden" name="id" value="<?= $edit['id']; ?>">
                    <?php
                        }
                    ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formOwner" class="form-label fw-bold">Dono do animal:</label>
                                <select id="formOwner" name="user_id" class="form-select" required>
                                    <option value="" disabled selected>Selecione o Dono</option>
                                    <?php
                                        $owners = $conn->query("SELECT id, full_name FROM users");
                                        foreach ($owners as $owner) {
                                        
                                            $selected = ($edit && $edit['user_id'] == $owner['id']) ? 'selected' : '';
                                            echo "<option value='{$owner['id']}' {$selected}>{$owner['full_name']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="formName" class="form-label fw-bold">Nome do Animal Perdido</label>
                                <input id="formName" type="text" name="name" class="form-control" placeholder="Ex: Boby"
                                    value="<?= $edit ? $edit['animal_name'] : ''; ?>" required maxlength="100">
                            </div>

                            <div class="mb-3">
                                <label for="formSince" class="form-label fw-bold">Perdido desde</label>
                                <input label="formSince" type="date" name="seen" class="form-control" 
                                    value="<?= $edit ? $edit['last_seen_date'] : ''; ?>" required max="<?= date('Y-m-d'); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="formPhone" class="form-label fw-bold">Contacto do Dono</label>
                                <input id="formPhone" type="text" name="phone" class="form-control" placeholder="Ex: +351 900000001"
                                    value="<?= $edit ? $edit['contact_phone'] : ''; ?>" required maxlength="20">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formLocation" class="form-label fw-bold">Visto em</label>
                                <input id="formLocation" type="text" name="local" class="form-control" placeholder="Ex: Lisboa"
                                    value="<?= $edit ? $edit['location'] : ''; ?>" required maxlength="255">
                            </div>

                            <div class="mb-3">
                                <label for="formLocation" class="form-label fw-bold">Fotografia do Animal</label>
                                <input id="formLocation" type="file" name="image" class="form-control" accept="image/*">
                            </div>

                            <?php
                                if($edit):
                            ?>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Encontrado</label>
                                        <div class="d-flex gap-3 mt-1"> <div class="form-check">
                                                <input id="formFound" type="radio" name="found" value="Yes" class="form-check-input" 
                                                    <?= ($edit && ($edit['found']) === 'Yes') ? 'checked' : ''; ?>>
                                                <label for="formFound" class="form-check-label">Encontrado</label>
                                            </div>
                                            <div class="form-check">
                                                <input id="formLost" type="radio" name="found" value="No" class="form-check-input" 
                                                    <?= ($edit && ($edit['found']) === 'No') ? 'checked' : ''; ?>>
                                                <label for="formLost" class="form-check-label">Perdido</label>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                endif;
                            ?>
                        </div>

                        <div class="modal-footer bg-light">
                            <a href="missing_animals" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" name="<?= $edit ? 'btnEditar' : 'btnCriar'; ?>"
                                class="btn btn-success px-4 fw-bold">
                                <i class="fa-solid fa-floppy-disk me-2"></i> <?= $edit ? 'Guardar Alterações' : 'Adicionar Animal Perdido'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>