<?php
    if(!$rerun):
        $metaTitle = '';
        $metaDescription = '';
    else:
        $stmt = $conn->prepare("SELECT a.*, b.name AS breed_name FROM animals a LEFT JOIN breeds b ON a.breed_id=b.id ORDER BY a.id ASC");
        $stmt->execute();
        $group= $stmt->get_result();

        # Processo de edição do modal
        $aniEdit = null;
        if (isset($_GET['editar'])) {
            $id = (int) $_GET['editar'];
            $stmt = $conn->prepare("SELECT a.*, b.name AS breed_name , s.name AS specie_name from animals a LEFT JOIN breeds b ON a.breed_id= b.id LEFT JOIN species s ON a.specie_id= s.id WHERE a.id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $aniEdit = $stmt->get_result()->fetch_assoc();
        }
?>

        <h1 class="fw-bold fs-2">Lista de Animais</h1>
        <div class="d-flex justify-content-end gap-2 mb-3">
            <a href="animalList?add" class="btn btn-success">+ Criar</a>
        </div>

        <?php include 'components/modal_animal.php'; ?>

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
                            <a href="animalList.php?editar=<?= $item['id']; ?>"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                            <a href="components/action_animal.php?action=eliminar&id=<?= $item['id']; ?>"
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
<?php
    endif;