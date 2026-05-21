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
			<table class="table table-striped table-hover text-center align-middle" id="missingAnimals">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">Id</th>
                        <th scope="col" class="text-center">Foto</th>
                        <th scope="col" class="text-center">Nome do animal</th>
                        <th scope="col" class="text-center">Utilizador</th>
                        <th scope="col" class="text-center">Contacto</th>
                        <th scope="col" class="text-center">Desde</th>
                        <th scope="col" class="text-center">Onde</th>
                        <th scope="col" class="text-center">Ação</th>
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
                                    <a href="<?= $basePath ?>/edit_lost?id=<?= $row['id'] ?>&edit=true" class="btn btn-primary">Editar</a>
                                    <a href="?id=<?= $row['id'] ?>&delete=true" class="btn btn-danger" onclick="return confirm('Têm a certeza que quer eliminar este processo?')">Eliminar</a>
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