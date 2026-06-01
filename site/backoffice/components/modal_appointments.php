<div class="modal fade" id="formModalappointment">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa-solid fa-paw me-2"></i>
                    <?= $appointmentEdit ? "Editar: " . $appointmentEdit['name_animal'] : "Novo Appointment"; ?>
                </h5>
            </div>

            <form action="components/action_appointment.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php if ($appointmentEdit): ?>
                        <input type="hidden" name="id_appointment" value="<?= $appointmentEdit['id']; ?>">
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nome do Animal</label>
                                <input type="text" name="name_animal" class="form-control" placeholder="Ex: Boby"
                                    value="<?= $appointmentEdit ? $appointmentEdit['name_animal'] : ''; ?>" required maxlength="50">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Escolha a Espécies:</label>
                                <select name="animal" id="select-especie" class="form-select" required>
                                    <option value="">Selecione qual é o Espécies</option>
                                    <option value="Cão" <?= ($appointmentEdit && $appointmentEdit['animal'] == 'cao') ? 'selected' : ''; ?>>Cão</option>
                                    <option value="Gato" <?= ($appointmentEdit && $appointmentEdit['animal'] == 'gato') ? 'selected' : ''; ?>>Gato</option>
                                    <option value="Outro" <?= ($appointmentEdit && $appointmentEdit['animal'] == 'outro') ? 'selected' : ''; ?>>Outro</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Escolha a Raça:</label>   
                                <input type="text" name="breed_animal" class="form-control" placeholder="Ex: Labrador"
                                    value="<?= $appointmentEdit ? $appointmentEdit['breed_animal'] : ''; ?>" required maxlength="50">
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Idade do Animal</label>
                                <input type="number" name="age_animal" class="form-control" placeholder="Ex: 5"
                                    value="<?= $appointmentEdit ? $appointmentEdit['age_animal'] : ''; ?>" required maxlength="2">
                            </div>
                        </div>
                        <?php
                        $dataEdicao = $horaEdicao = '';

                        if (!empty($appointmentEdit['appointment_date'])) {
                            $dt = new DateTime($appointmentEdit['appointment_date']);
                            $dataEdicao = $dt->format('Y-m-d'); 
                            $horaEdicao = $dt->format('H:i');   
                        }
                        ?>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Data da consulta</label>
                                <input type="date" name="date" class="form-control" 
                                    value="<?= $dataEdicao;?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Escolha o horário:</label>
                                <select name="horary" id="select-horary" class="form-select" required>
                                    <option value="">Selecione o horário</option>
                                    <option value="10:00" <?= ($horaEdicao === '10:00') ? 'selected' : ''; ?>>10:00</option>
                                    <option value="15:00" <?= ($horaEdicao === '15:00') ? 'selected' : ''; ?>>15:00</option>
                                    <option value="18:00" <?= ($horaEdicao === '18:00') ? 'selected' : ''; ?>>18:00</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Escolha o veterinário:</label>
                                <select name="vet_id" id="select-vet" class="form-select" required>
                                    <option value="">Selecione um veterinário</option>
                                    <?php
                                    $veterinarians = $conn->query("SELECT id, name FROM veterinarians");
                                    foreach ($veterinarians as $vet) {
                                        $selected = ($appointmentEdit && $appointmentEdit['vet_id'] == $vet['id']) ? 'selected' : '';
                                        echo "<option value='{$vet['id']}' {$selected}>{$vet['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Escolha o estado:</label>
                                <select name="status" id="select-status" class="form-select" required>
                                    <option value="">Selecione o estado</option>
                                    <option value="concluida" <?= ($appointmentEdit && $appointmentEdit['status'] == 'concluida') ? 'selected' : ''; ?>>Concluído</option>
                                    <option value="agendada" <?= ($appointmentEdit && $appointmentEdit['status'] == 'agendada') ? 'selected' : ''; ?>>Agendado</option>
                                    <option value="cancelada" <?= ($appointmentEdit && $appointmentEdit['status'] == 'cancelada') ? 'selected' : ''; ?>>Cancelado</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer bg-light">
                            <a href="appointmentList" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" name="<?= $appointmentEdit ? 'btnEditar' : 'btnCriar'; ?>"
                                class="btn btn-success px-4 fw-bold">
                                <i class="fa-solid fa-floppy-disk me-2"></i> <?= $appointmentEdit ? 'Guardar Alterações' : 'Adicionar Animal'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>