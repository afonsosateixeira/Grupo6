<?php
require_once("../config.php");

//Route
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

if ($basePath !== '' && $basePath !== '/' && str_starts_with($path, $basePath))
    $path = substr($path, strlen($basePath));

$route = trim($path, '/');

if ($route === '')
    $route = 'index';

if (str_contains($route, '.'))
    $route = pathinfo($route, PATHINFO_FILENAME);


$stmt = $config->prepare("SELECT a.*, b.name AS breed_name FROM animals a LEFT JOIN breeds b ON a.breed_id=b.id ORDER BY a.id ASC");
$stmt->execute();
$group= $stmt->get_result();

// Editar
$aniEdit = null;
if (isset($_GET['btnEditar'])) {
    $id = (int) $_GET['btnEditar'];
    $sqlEdit = "SELECT * FROM animals WHERE id = $id";
    $res = $config->query($sqlEdit);
    $aniEdit = $res->fetch_assoc();
}



?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <?php
    $metaTitle = "Gestão de Animais";
    $metaDescription = "";
    $backOffice = true;
    require_once "../components/head.php";
    ?>
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/animalList.css">
</head>

<body>
    <?php require_once("../components/sidebar.html"); ?>

    <h1 class="fw-bold fs-2">Lista de Animais</h1>
    <div class="d-flex justify-content-end gap-2 mb-3">
        <?php require_once("../components/searchbar.php"); ?>
        <a href="animalList.php?add" class="btn btn-success">+ Criar</a>
    </div>
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

                <form action="action_animal.php" method="POST" enctype="multipart/form-data">
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
                            <select name="specie_id" id="select-especie" class="form-select" required>
                                <option value="">Selecione uma Espécie</option>
                                <?php
                                $especie = $config->query("SELECT id, name FROM species");
                                foreach ($especie as $esp) {
                                    echo "<option value='{$esp['id']}'>{$esp['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Escolha a Raça:</label>
                            <select name="breed_id" id="select-raca" class="form-select" required disabled>
                                <option value="">Selecione primeiro a espécie</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" class="form-control" 
                                value="<?= $aniEdit ? $aniEdit['birth_date'] : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Fotografia</label>
                            <input type="file" name="image" class="form-control" accept="image/*" <?= $aniEdit ? '' : 'required'; ?>>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Género</label>
                            <div class="form-check">
                                <input type="radio" name="gender" value="Macho" class="form-check-input" 
                                    <?= ($aniEdit && $aniEdit['gender'] === 'Macho') ? 'checked' : ''; ?>>
                                <label class="form-check-label">Macho</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="gender" value="Fêmea" class="form-check-input" 
                                    <?= ($aniEdit && $aniEdit['gender'] === 'Fêmea') ? 'checked' : ''; ?>>
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
    <table class="table striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Nome</th>
                <th>Raça</th>
                <th>Sexo</th>
                <th>Idade</th>
                <th>Porte</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($group as $item): ?>
                <tr>
                    <td><?= $item['id']; ?></td>
                    <td>
                        <?php 
                            $caminhoImagem = !empty($item['image']) ? "../assets/img/animals/" . $item['image'] : "../assets/img/defaultAnimals.png"; 
                        ?>
                    <img class="rounded-circle img-thumbnail round-image" src="<?= $caminhoImagem ?>" alt="Foto do animal">
                    </td>
                    <td><?= $item['name']; ?></td>
                    <td><?= $item['breed_name']; ?></td>
                    <td><?= $item['gender']; ?></td>
                    <td><?= $item['birth_date']; ?></td>
                    <td><?= $item['size']; ?></td>
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
    <script src="assets/js/animalList.js"></script>
</body>

</html>