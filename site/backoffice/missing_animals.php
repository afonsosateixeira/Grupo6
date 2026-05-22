<?php
	if(!$rerun):
		$metaTitle = 'Lista de Útilizadores';
		$metaDescription = 'Lista de Útilizadores da Poppy and Max';

        if(!empty($_GET['delete']) && !empty($_GET['id'])){
            $id = $_GET['id'];

            $stmt = $conn->prepare("DELETE FROM lost_animals WHERE id = ? ");
            $stmt->bind_param('i', $id);
            $stmt->execute();

            $stmt->close();
            $conn->close();

            header('Location: ./missing_animals');
            exit();
        }

        $query = $conn->query("SELECT * FROM vw_lost_pets_radar");
	else:
?>
		<section class="ms-2">
            <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Animais Perdidos</h1>
			<table class="table table-striped table-hover" id="missingAnimals">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Nome do animal</th>
                        <th>Utilizador</th>
                        <th>Contacto</th>
                        <th>Desde</th>
                        <th>Onde</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($query as $row):
                    ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><img src="../assets/img/lost/<?= !empty($row['photo']) ? htmlspecialchars($row['photo']) : 'default_lost.png' ?>" class="card-img" alt="Foto do <?= htmlspecialchars($row['animal']) ?>"></td>
                                <td><?= htmlspecialchars($row['animal']) ?></td>
                                <td><?= htmlspecialchars($row['reporter']) ?></td>
                                <td><?= htmlspecialchars($row['contact']) ?></td>
                                <td><?= htmlspecialchars($row['since']) ?></td>
                                <td><?= htmlspecialchars($row['location']) ?></td>
                                <td>
                                    <a href="<?= $basePath ?>/edit_lost?id=<?= $row['id'] ?>&edit=true"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="?id=<?= $row['id'] ?>&delete=true" onclick="return confirm('Têm a certeza que quer eliminar este processo?')"><i style="color: #dc3545;" class="fa-solid fa-trash"></i></a>
                        <a href=""</a>
                        <a href=""></a>
                    </td>
                            </tr>
                    <?php
                        endforeach;
                    ?>
                </tbody>
            </table>
		</section>
<?php
	endif;