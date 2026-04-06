<?php
require_once('config.php');

$adotEdit = null;
if (isset($_GET['btnEditar'])) {
    $id = (int) $_GET['btnEditar'];
    $res = $config->query("SELECT * FROM adopters WHERE id = $id");
    $adotEdit = $res->fetch_assoc();
}

$lista = $config->query("SELECT * FROM adopters ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/modalForm.css">
</head>

<body>
    <?php include('assets/components/sidebar.php'); ?>
    <a href="adopterList.php?add" class="btn btn-success">Adicionar Novo Adotante</a>

    <div class="modal fade" id="formModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-paw me-3"></i>
                        <?php echo $adotEdit ? "Editar: " . $adotEdit['full_name'] : "Novo Adotante"; ?>
                    </h5>
                </div>

                <form action="action_adopter.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <?php if ($adotEdit): ?>
                            <input type="hidden" name="id_adotante" value="<?php echo $adotEdit['id']; ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome</label>
                            <input type="text" name="full_name" placeholder="Ex: André" class="form-control"
                                value="<?php echo $adotEdit ? $adotEdit['full_name'] : ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" placeholder="Ex: andre@gmail.com" class="form-control" value="<?php echo $adotEdit ? $adotEdit['email'] : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Número</label>
                            <input type="number" name="phone" placeholder="Ex: 911 922 922" class="form-control" value="<?php echo $adotEdit ? $adotEdit['phone'] : ''; ?>">
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <a href="adopterList.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4" name="<?php echo $adotEdit ? 'btnEditar' : 'btnCriar'; ?>">
                            <?php echo $adotEdit ? 'Guardar' : 'Adicionar'; ?>
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
                <th>Email</th>
                <th>Telemóvel</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($linha = $lista->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $linha['id']; ?></td>
                    <td><?php echo $linha['full_name']; ?></td>
                    <td><?php echo $linha['email']; ?></td>
                    <td><?php echo $linha['phone']; ?></td>
                    <td>
                        <a href="action_adopter.php?btnEditar=<?php echo $linha['id']; ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a href="action_adopter.php?btnEliminar=<?php echo $linha['id']; ?>"
                            onclick="return confirm('Apagar este adotante?')"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <script src="assets/js/modalForm.js"></script>
    <script>
        window.onload = function () {
            <?php if ($adotEdit || isset($_GET['add'])): ?>
                var meuModal = new bootstrap.Modal(document.getElementById('formModal'));
                meuModal.show();
            <?php endif; ?>
        };
    </script>
</body>

</html>