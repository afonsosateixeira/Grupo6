<?php
require_once("../config.php");

	$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

	if ($basePath !== '' && $basePath !== '/' && str_starts_with($path, $basePath))
		$path = substr($path, strlen($basePath));

	$route = trim($path, '/');

	if ($route === '')
		$route = 'index';

	if (str_contains($route, '.'))
		$route = pathinfo($route, PATHINFO_FILENAME);

$adotEdit = null;
if (isset($_GET['btnEditar'])) {
    $id = (int) $_GET['btnEditar'];
    $res = $config->query("SELECT * FROM adopters WHERE id = $id");
    $adotEdit = $res->fetch_assoc();
}

$lista = $config->query("SELECT * FROM adopters ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <?php
        $metaTitle = "Lista de Adotantes";
        $metaDescription = "";
        $backOffice = true;
        require_once "../components/head.php";
    ?>
    <link rel="stylesheet" href="../assets/css/sidebar.css">
</head>

<body>
    <?php require_once("../components/sidebar.html");?>
    <a href="adopterList.php?add" class="btn btn-success">Adicionar Novo Adotante</a>

    <div class="modal fade" id="formModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-paw me-3"></i>
                        <?= $adotEdit ? "Editar: " . $adotEdit['full_name'] : "Novo Adotante"; ?>
                    </h5>
                </div>

                <form action="action_adopter.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <?php if ($adotEdit): ?>
                            <input type="hidden" name="id_adotante" value="<?= $adotEdit['id']; ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome</label>
                            <input type="text" name="full_name" placeholder="Ex: André" class="form-control"
                                value="<?= $adotEdit ? $adotEdit['full_name'] : ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" placeholder="Ex: andre@gmail.com" class="form-control" value="<?= $adotEdit ? $adotEdit['email'] : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Número</label>
                            <input type="number" name="phone" placeholder="Ex: 911 922 922" class="form-control" value="<?= $adotEdit ? $adotEdit['phone'] : ''; ?>">
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <a href="adopterList.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4" name="<?= $adotEdit ? 'btnEditar' : 'btnCriar'; ?>">
                            <?= $adotEdit ? 'Guardar' : 'Adicionar'; ?>
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
                    <td><?= $linha['id']; ?></td>
                    <td><?= $linha['full_name']; ?></td>
                    <td><?= $linha['email']; ?></td>
                    <td><?= $linha['phone']; ?></td>
                    <td>
                        <a href="action_adopter.php?btnEditar=<?= $linha['id']; ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a href="action_adopter.php?btnEliminar=<?= $linha['id']; ?>"
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