<?php
    // Editar
    $aniEdit = null;
    if (isset($_GET['btnEditar'])) {
        $id = (int) $_GET['btnEditar'];
        $sqlEdit = "SELECT * FROM animals WHERE id = $id";
        $res = $conn->query($sqlEdit);
        $aniEdit = $res->fetch_assoc();
    }

    $sql = "SELECT * FROM animals ORDER BY id ASC";
    $group = $conn->query($sql);
?>

    <?php require_once("../components/searchbar.php"); ?>
    <a href="animalList.php?add" class="btn btn-success">Adicionar Novo Animal</a>

    <!--Modal-->
    <div class="modal fade" id="formModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-paw me-2"></i>
                        <?= $aniEdit ? "Editar: " . $aniEdit['name'] : "Novo Animal"; ?>
                    </h5>
                </div>

                <form action="action_animal" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <?php if ($aniEdit): ?>
                            <input type="hidden" name="id_animal" value="<?= $aniEdit['id']; ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome do Animal</label>
                            <input type="text" name="nome_animal" class="form-control" placeholder="Ex: Boby"
                                value="<?= $aniEdit ? $aniEdit['name'] : ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Escolha a Espécie:</label>
                            <select name="specie_id" class="form-select" required>
                                <option value="">Selecione uma Espécie</option>

                                <?php
                                $executar = $conn->query("SELECT id, name FROM species");

                                while ($row = $executar->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Escolha a Raça:</label>
                            <select name="breed_id" class="form-select" required>
                                <option value="">Selecione uma Raça</option>
                                <?php   
                                $raca = $conn->query("SELECT id, name FROM breeds");

                                while ($rac = $raca->fetch_assoc()) { 
                                    echo "<option value='" . $rac['id'] . "'>" . $rac['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" class="form-control" 
                                value="<?= $aniEdit ? $aniEdit['birth_date'] : ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Fotografia</label>
                            <input type="file" name="image" class="form-control" accept="image/*" <?= $aniEdit ? '' : 'required'; ?>>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Género</label>
                            <div class="form-check">
                                <input type="radio" name="gender" value="Macho" class="form-check-input" 
                                    <?= ($aniEdit && $aniEdit['gender'] === 'Macho') ? 'checked' : ''; ?> required>
                                <label class="form-check-label">Macho</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="gender" value="Fêmea" class="form-check-input" 
                                    <?= ($aniEdit && $aniEdit['gender'] === 'Fêmea') ? 'checked' : ''; ?> required>
                                <label class="form-check-label">Fêmea</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Descrição</label>
                            <textarea name="description" class="form-control"><?= $aniEdit ? $aniEdit['description'] : ''; ?></textarea>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <a href="animalList.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="<?= $aniEdit ? 'btnEditar' : 'btnCriar'; ?>"
                            class="btn btn-primary px-4">
                            <?= $aniEdit ? 'Guardar Alterações' : 'Adicionar Animal'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!--Tabela-->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Raça</th>
                <th>DataNasc</th>
                <th>Género</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($group as $item): ?>
                <tr>
                    <td><?= $item['id']; ?></td>
                    <td><?= $item['name']; ?></td>
                    <td><?= $item['breed_id']; ?></td>
                    <td><?= $item['birth_date']; ?></td>
                    <td><?= $item['gender']; ?></td>
                    <td><?= $item['description']; ?></td>
                    <td><?= $item['status']; ?></td>

                    <td>
                        <a href="action_animal.php?btnEditar=<?= $item['id']; ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a href="action_animal.php?btnEliminar=<?= $item['id']; ?>"
                            onclick="return confirm('Apagar este adotante?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        window.onload = function () {
            <?php if ($aniEdit || isset($_GET['add'])): ?>
                var meuModal = new bootstrap.Modal(document.getElementById('formModal'));
                meuModal.show();
            <?php endif; ?>
        };
    </script>