<div class="modal fade" id="formModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-users me-2"></i>
                    <?= $edit ? "Editar: " . $edit['full_name'] : "Novo Utilizador"; ?>
                </h5>
            </div>

            <form action="components/action_users.php" method="POST">
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
                                <label for="formName" class="form-label fw-bold">Nome do Utilizador</label>
                                <input id="formName" type="text" name="name" class="form-control" placeholder="Ex: André"
                                    value="<?= $edit ? $edit['full_name'] : ''; ?>" required maxlength="150">
                            </div>

                            <div class="mb-3">
                                <label for="formEmail" class="form-label fw-bold">Email</label>
                                <input id="formEmail" type="email" name="email" class="form-control" placeholder="Ex: andre@email.com"
                                    value="<?= $edit ? $edit['email'] : ''; ?>" required maxlength="100">
                            </div>

                            <div class="mb-3">
                                <label for="formPass" class="form-label fw-bold">Password</label>
                                <input id="formPass" type="password" name="pass" class="form-control" placeholder="Ex: *********"
                                    value="" <?= $edit ? '' : 'required' ?> maxlength="255">
                            </div>

                            <div class="mb-3">
                                <label for="formPhone" class="form-label fw-bold">Telefóne</label>
                                <input id="formPhone" type="text" name="phone" class="form-control" placeholder="Ex: +351 900000001"
                                    value="<?= $edit ? $edit['phone'] : ''; ?>" required maxlength="20">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formCity" class="form-label fw-bold">Cidade</label>
                                <input id="formCity" type="text" name="local" class="form-control" placeholder="Ex: Leiria"
                                    value="<?= $edit ? $edit['local'] : ''; ?>" maxlength="50">
                            </div>

                            <div class="mb-3">
                                <label for="formStreet" class="form-label fw-bold">Rua</label>
                                <input id="formStreet" type="text" name="street" class="form-control" placeholder="Ex: Rua do Utilizador, nº9"
                                    value="<?= $edit ? $edit['street'] : ''; ?>" maxlength="150">
                            </div>

                            <div class="mb-3">
                                <label for="formPostal" class="form-label fw-bold">Código Postal</label>
                                <input id="formPostal" type="text" name="cp" class="form-control" placeholder="Ex: 9001-901"
                                    value="<?= $edit ? $edit['cp'] : ''; ?>" maxlength="8">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Permissões</label>
                                <div class="d-flex gap-3 mt-1"> <div class="form-check">
                                        <input id="formUserA" type="radio" name="role" value="admin" class="form-check-input" 
                                            <?= ($edit && ($edit['role']) === 'admin') ? 'checked' : ''; ?> required>
                                        <label for="formUserA" class="form-check-label">Administrador</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="formUserN" type="radio" name="role" value="n" class="form-check-input" 
                                            <?= ($edit && ($edit['role']) === 'n') ? 'checked' : ''; ?> required>
                                        <label for="formUserN" class="form-check-label">Utilizador Normal</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer bg-light">
                            <a href="user_list" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" name="<?= $edit ? 'btnEditar' : 'btnCriar'; ?>"
                                class="btn btn-success px-4 fw-bold">
                                <i class="fa-solid fa-floppy-disk me-2"></i> <?= $edit ? 'Guardar Alterações' : 'Adicionar Utilizador'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>