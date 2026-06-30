<div class="modal fade" id="formModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-handshake me-2"></i>
                    <?= $edit ? "Editar Parceiro: " . htmlspecialchars($edit['company_name']) : "Novo Parceiro Comercial"; ?>
                </h5>
            </div>

            <form action="components/action_partners.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="modal-body">
                    <?php if ($edit){ ?>
                        <input type="hidden" name="id" value="<?= $edit['id']; ?>">
                    <?php } ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formCompanyName" class="form-label fw-bold">Nome da Empresa</label>
                                <input id="formCompanyName" type="text" name="company_name" class="form-control" placeholder="Ex: Petshop Alegria"
                                    value="<?= $edit ? htmlspecialchars($edit['company_name']) : ''; ?>" required maxlength="150">
                            </div>

                            <div class="mb-3">
                                <label for="formContactPerson" class="form-label fw-bold">Pessoa de Contacto</label>
                                <input id="formContactPerson" type="text" name="contact_person" class="form-control" placeholder="Ex: Sr. Joaquim"
                                    value="<?= $edit ? htmlspecialchars($edit['contact_person']) : ''; ?>" required maxlength="100">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="formPhone" class="form-label fw-bold">Telemóvel / Telefone</label>
                                <input id="formPhone" type="text" name="phone" class="form-control" placeholder="Ex: 221111111"
                                    value="<?= $edit ? htmlspecialchars($edit['phone']) : ''; ?>" required maxlength="20">
                            </div>

                            <div class="mb-3">
                                <label for="formEmail" class="form-label fw-bold">Email Comercial</label>
                                <input id="formEmail" type="email" name="email" class="form-control" placeholder="Ex: geral@empresa.com"
                                    value="<?= $edit ? htmlspecialchars($edit['email']) : ''; ?>" maxlength="100">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="formPhoto" class="form-label fw-bold">Logótipo do Parceiro</label>
                                <input id="formPhoto" type="file" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <a href="partners" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" name="<?= $edit ? 'btnEditar' : 'btnCriar'; ?>" class="btn btn-success px-4 fw-bold">
                        <i class="fa-solid fa-floppy-disk me-2"></i> <?= $edit ? 'Guardar Alterações' : 'Adicionar Parceiro'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>