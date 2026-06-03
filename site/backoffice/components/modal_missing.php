<div class="modal fade" id="formModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-paw me-2"></i>
                    <?= $edit ? "Editar: " . $edit['name'] : "Novo Animal"; ?>
                </h5>
            </div>

            <form action="components/action_animal.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php if ($edit): ?>
                        <input type="hidden" name="id_animal" value="<?= $edit['id']; ?>">
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nome do Animal</label>
                                <input type="text" name="nome_animal" class="form-control" placeholder="Ex: Boby"
                                    value="<?= $edit ? $edit['name'] : ''; ?>" required maxlength="50">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Escolha a Espécie:</label>
                                <select name="specie_id" id="select-especie" class="form-select" required>
                                    <option value="">Selecione uma Espécie</option>
                                    <?php
                                    $especie = $conn->query("SELECT id, name FROM species");
                                    foreach ($especie as $esp) {
                                    
                                        $selected = ($edit && $edit['specie_id'] == $esp['id']) ? 'selected' : '';
                                        echo "<option value='{$esp['id']}' {$selected}>{$esp['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Escolha a Raça:</label>
                                <select name="breed_id" id="select-raca" class="form-select">
                                    <option value="">Selecione uma raça</option>
                                    <?php
                                    $raca = $conn->query("SELECT id, name FROM breeds");
                                    foreach ($raca as $rac) {
                                        $selected = ($edit && $edit['breed_id'] == $rac['id']) ? 'selected' : '';
                                        echo "<option value='{$rac['id']}' {$selected}>{$rac['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Fotografia</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Data de Nascimento</label>
                                <input type="date" name="data_nascimento" class="form-control" 
                                    value="<?= $edit ? $edit['birth_date'] : ''; ?>" max="<?= date('Y-m-d'); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Porte</label>
                                <select name="size" class="form-select">
                                    <option value="">Selecione o porte</option>
                                    <option value="pequeno" <?= ($edit && ($edit['size']) === 'Pequeno') ? 'selected' : ''; ?>>Pequeno</option>
                                    <option value="médio" <?= ($edit && ($edit['size']) === 'Médio') ? 'selected' : ''; ?>>Médio</option>
                                    <option value="grande" <?= ($edit && ($edit['size']) === 'Grande') ? 'selected' : ''; ?>>Grande</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Género</label>
                                <div class="d-flex gap-3 mt-1"> <div class="form-check">
                                        <input type="radio" name="gender" value="Macho" class="form-check-input" 
                                            <?= ($edit && ($edit['gender']) === 'Macho') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label">Macho</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="gender" value="Fêmea" class="form-check-input" 
                                            <?= ($edit && ($edit['gender']) === 'Fêmea') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label">Fêmea</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Descrição</label>
                                <textarea name="description" class="form-control" rows="3" maxlength="500" placeholder="Breve descrição do animal..."><?= $edit ? $edit['description'] : ''; ?></textarea>
                            </div>
                        </div>

                        <div class="modal-footer bg-light">
                            <a href="animalList" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" name="<?= $edit ? 'btnEditar' : 'btnCriar'; ?>"
                                class="btn btn-success px-4 fw-bold">
                                <i class="fa-solid fa-floppy-disk me-2"></i> <?= $edit ? 'Guardar Alterações' : 'Adicionar Animal'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>