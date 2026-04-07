<?php
require_once("../config.php");

$animalParaEditar = null;
if (isset($_GET['btnEditar'])) {
    $id = (int) $_GET['btnEditar'];
    $res = $config->query("SELECT * FROM animals WHERE id = $id");
    $animalParaEditar = $res->fetch_assoc();
}

$lista = $config->query("SELECT * FROM animals ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <?php
        $metaTitle = "Lista de Animais";
        $metaDescription = "";
        $backOffice = true;
        require_once "components/head.php";
    ?>
    <meta charset="UTF-8">
    <title>Gestão de Animais</title>
    <link rel="stylesheet" href="assets/css/modalForm.css">
</head>

<body>
    <?php require_once("../components/sidebar.html");?>

    <a href="animalList.php?add" class="btn btn-success">Adicionar Novo Animal</a>

    <div class="modal fade" id="formModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-paw me-2"></i>
                        <?php echo $animalParaEditar ? "Editar: " . $animalParaEditar['name'] : "Novo Animal"; ?>
                    </h5>
                </div>

                <form action="action_animal.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <?php if ($animalParaEditar): ?>
                            <input type="hidden" name="id_animal" value="<?php echo $animalParaEditar['id']; ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome do Animal</label>
                            <input type="text" name="nome_animal" class="form-control" placeholder="Ex: Boby"
                                value="<?php echo $animalParaEditar ? $animalParaEditar['name'] : ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Fotografia</label>
                            <input type="file" name="image" class="form-control" accept="image/*" <?php echo $animalParaEditar ? '' : 'required'; ?>>
                        </div>

                        <div class="mb-3">
                            <label>Escolha a Raça:</label>
                            <select name="breed_id" class="form-select" required>
                                <option value="">Selecione uma Raça</option>

                                <?php
                             
                                $sql = "SELECT id, name FROM breeds";
                                $executar = $config->query($sql);

                                
                                while ($row = $executar->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>         
                    </div>

                    <div class="modal-footer bg-light">
                        <a href="animalList.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="<?php echo $animalParaEditar ? 'btnEditar' : 'btnCriar'; ?>"
                            class="btn btn-primary px-4">
                            <?php echo $animalParaEditar ? 'Guardar Alterações' : 'Adicionar Animal'; ?>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($linha = $lista->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $linha['id']; ?></td>
                    <td><?php echo $linha['name']; ?></td>
                    <td>
                        <a href="action_animal.php?btnEditar=<?php echo $linha['id']; ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a href="action_animal.php?btnEliminar=<?php echo $linha['id']; ?>"
                            onclick="return confirm('Apagar este adotante?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script src="assets/js/modalForm.js"></script>
    <script>
        window.onload = function () {
            <?php if ($animalParaEditar || isset($_GET['add'])): ?>
                var meuModal = new bootstrap.Modal(document.getElementById('formModal'));
                meuModal.show();
            <?php endif; ?>
        };
    </script>
</body>

</html>