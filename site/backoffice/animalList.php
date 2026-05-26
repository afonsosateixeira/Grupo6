<?php
    if(!$rerun):
        $metaTitle = '';
        $metaDescription = '';
    else:
        $group = $conn->query('SELECT a.*, b.name AS breed_name FROM animals a LEFT JOIN breeds b ON a.breed_id=b.id ORDER BY a.id ASC');

        # Processo de edição do modal
        $aniEdit = null;
        if ($id = (int) ($_GET['editar'] ?? 0)) {
            $sql = 'SELECT a.*, b.name AS breed_name FROM animals a LEFT JOIN breeds b ON a.breed_id=b.id WHERE a.id = ?';
            $aniEdit = prepareQuery($conn, $sql, 'i', $id)->get_result()->fetch_assoc();
        }
?>

    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Animais</h1>
        <div class="d-flex justify-content-end gap-2 mb-3">
            <a href="?add" class="btn btn-success">+ Criar</a>
        </div>

        <?php include 'components/modal_animal.php'; ?>

        <table class="table striped table-hover" id="animalTable">
            <thead>
                <tr>
                    <th>ID</th><th>Foto</th><th>Nome</th><th>Raça</th><th>Idade</th>
                    <th>Porte</th><th>Descrição</th><th>Status</th><th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($group as $item): ?>
                    <tr>
                        <td><?= $item['id']; ?></td>
                        <td>
                            <?php 
                                $cor= $item['gender'] === 'Macho'?'#89CFF0' : '#F48FB1';
                                $caminhoImagem = !empty($item['image']) ? "../assets/img/animals/{$item['image']}" : "../assets/img/defaultAnimals.png"; 
                            ?>
                        <img class="rounded-circle img-thumbnail round-image text-muted" src="<?= $caminhoImagem ?>" style="border: 3px solid<?=$cor?>;" alt="Foto do animal">
                        </td>
                        <td><?= htmlspecialchars($item['name']); ?></td>
                        <td><?= mostrarValor2($item['breed_name']); ?></td>
                        <td><?= mostrarIdade($item['birth_date']); ?></td>
                        <td><?= mostrarValor2($item['size']); ?></td>
                        <td style="text-wrap: pretty"><?= htmlspecialchars($item['description']); ?></td>
                        <td class="fw-bold" style="color:<?= corStatus($item['status'])?>;"><?= $item['status']; ?></td>
                        <td>
                            <a href="?editar=<?= $item['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="components/action_animal.php?action=eliminar&id=<?= $item['id']; ?>"
                                onclick="return confirm('Deseja apagar este animal?')">
                                <i style="color: #dc3545;" class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>   
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
<?php endif;