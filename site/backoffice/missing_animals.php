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

            header('Location: ./missing_animals');
            exit();
        }

        $query = $conn->query("SELECT * FROM vw_lost_pets_radar");

        $edit = null;
        if(isset($_GET['edit'])){
            $id = $_GET['edit'];
            $stmt = $conn->prepare("SELECT * FROM lost_animals WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $edit = $stmt->get_result()->fetch_assoc();
            $stmt->close();
        };
	else:
?>
		<section class="ms-2">
            <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Animais Perdidos</h1>

            <div class="d-flex justify-content-end gap-2 mb-3">
                <a href="?add" class="btn btn-success">+ Criar</a>
            </div>

            <?php
                require 'components/modal_missing.php';
            ?>

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
                                <td><img src="../assets/img/lost/<?= !empty($row['photo']) ? htmlspecialchars($row['photo']) : 'default_lost.png' ?>" alt="Foto do <?= htmlspecialchars($row['animal']) ?>"></td>
                                <td><?= htmlspecialchars($row['animal']) ?></td>
                                <td><?= htmlspecialchars($row['reporter']) ?></td>
                                <td><?= htmlspecialchars($row['contact']) ?></td>
                                <td><?= htmlspecialchars($row['since']) ?></td>
                                <td><?= htmlspecialchars($row['location']) ?></td>
                                <td>
                                    <a href="?edit=<?= $row['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="?id=<?= $row['id'] ?>&delete=true" onclick="return confirm('Têm a certeza que quer eliminar este processo?')"><i style="color: #dc3545;" class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                    <?php
                        endforeach;
                    ?>
                </tbody>
            </table>
		</section>

        <script>
            window.onload = function(){
                <?php
                    if($edit || isset($_GET['add'])){
                ?>
                    var modal = new bootstrap.Modal(document.getElementById('formModal'));
                    modal.show();
                <?php
                    }
                ?>
            }
        </script>
<?php
	endif;