<?php
require_once("../config.php");
require_once("../components/helpers.php");

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
    $sqlEdit = "SELECT a.*, b.name AS breed_name , s.name AS specie_name from animals a LEFT JOIN breeds b ON a.breed_id= b.id LEFT JOIN species s ON a.specie_id= s.id WHERE a.id = $id";
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
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css">
</head>

<body>
    <?php require_once("../components/sidebar.html"); ?>

    <h1 class="fw-bold fs-2">Lista de Animais</h1>
    <div class="d-flex justify-content-end gap-2 mb-3">
        <a href="animalList.php?add" class="btn btn-success">+ Criar</a>
    </div>

    <!--Modal-->
    <div class="modal fade" id="formModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nome do Animal</label>
                                    <input type="text" name="nome_animal" class="form-control" placeholder="Ex: Boby"
                                        value="<?= $aniEdit ? $aniEdit['name'] : ''; ?>" required maxlength="50">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Escolha a Espécie:</label>
                                    <select name="specie_id" id="select-especie" class="form-select" required>
                                        <option value="">Selecione uma Espécie</option>
                                        <?php
                                        $especie = $config->query("SELECT id, name FROM species");
                                        foreach ($especie as $esp) {
                                        
                                            $selected = ($aniEdit && $aniEdit['specie_id'] == $esp['id']) ? 'selected' : '';
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
                                        $raca = $config->query("SELECT id, name FROM breeds");
                                        foreach ($raca as $rac) {
                                            $selected = ($aniEdit && $aniEdit['breed_id'] == $rac['id']) ? 'selected' : '';
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
                                        value="<?= $aniEdit ? $aniEdit['birth_date'] : ''; ?>" max="<?= date('Y-m-d'); ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Porte</label>
                                    <select name="size" class="form-select">
                                        <option value="">Selecione o porte</option>
                                        <option value="pequeno" <?= ($aniEdit && ($aniEdit['size']) === 'Pequeno') ? 'selected' : ''; ?>>Pequeno</option>
                                        <option value="médio" <?= ($aniEdit && ($aniEdit['size']) === 'Médio') ? 'selected' : ''; ?>>Médio</option>
                                        <option value="grande" <?= ($aniEdit && ($aniEdit['size']) === 'Grande') ? 'selected' : ''; ?>>Grande</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Género</label>
                                    <div class="d-flex gap-3 mt-1"> <div class="form-check">
                                            <input type="radio" name="gender" value="Macho" class="form-check-input" 
                                                <?= ($aniEdit && ($aniEdit['gender']) === 'Macho') ? 'checked' : ''; ?> required>
                                            <label class="form-check-label">Macho</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="gender" value="Fêmea" class="form-check-input" 
                                                <?= ($aniEdit && ($aniEdit['gender']) === 'Fêmea') ? 'checked' : ''; ?> required>
                                            <label class="form-check-label">Fêmea</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Descrição</label>
                                    <textarea name="description" class="form-control" rows="3" maxlength="500" placeholder="Breve descrição do animal..."><?= $aniEdit ? $aniEdit['description'] : ''; ?></textarea>
                                </div>
                            </div>

                            <div class="modal-footer bg-light">
                                <a href="animalList.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" name="<?= $aniEdit ? 'btnEditar' : 'btnCriar'; ?>"
                                    class="btn btn-success px-4 fw-bold">
                                    <i class="fa-solid fa-floppy-disk me-2"></i> <?= $aniEdit ? 'Guardar Alterações' : 'Adicionar Animal'; ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!--Tabela-->
    <table class="table striped" id="animalTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Nome</th>
                <th>Raça</th>
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
                            $cor= $item['gender'] === 'Macho'?'#89CFF0' : '#F48FB1';
                            $caminhoImagem = !empty($item['image']) ? "../assets/img/animals/" . $item['image'] : "../assets/img/defaultAnimals.png"; 
                        ?>
                    <img class="rounded-circle img-thumbnail round-image text-muted" src="<?= $caminhoImagem ?>" style="border: 3px solid<?=$cor?>;" alt="Foto do animal">
                    </td>
                    <td><?= $item['name']; ?></td>
                    <td><?= mostrarValor2($item['breed_name']); ?></td>
                    <td><?= mostrarIdade($item['birth_date']); ?></td>
                    <td><?= mostrarValor2($item['size']); ?></td>
                    <td style="text-wrap: pretty"><?= $item['description']; ?></td>
                    <td class="fw-bold" style="color:<?= corStatus($item['status'])?>;"><?= $item['status']; ?></td>
                    <td>
                        <a href="action_animal.php?btnEditar=<?= $item['id']; ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                        <a href="action_animal.php?btnEliminar=<?= $item['id']; ?>"
                            onclick="return confirm('Apagar este adotante?')"><i style="color: #dc3545;" class="fa-solid fa-trash"></i></a>
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
    <script src="https://code.jquery.com/jquery-4.0.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#animalTable', {
            language: {
                url: '../assets/js/pt_PT.json',
            },
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],   
            columns: [null,{ orderable: false,width: '100px' }, null, null, null, null,{ width: '600px' }, null, {orderable: false}] 
            
        });
    </script>
</body>

</html>