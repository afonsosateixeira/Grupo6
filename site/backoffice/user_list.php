<?php
	if(!$rerun):
		$metaTitle = 'Lista de Útilizadores';
		$metaDescription = 'Lista de Útilizadores da Poppy and Max';

        $perPage = 10;
        $idMin = $_GET['id_min'] ?? 1;
        $idMax = $idMin + ($perPage - 1);
        $currentPage = $idMax / $perPage;

        if(!empty($_GET['delete']) && !empty($_GET['id'])){
            $id = $_GET['id'];

            $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
            $stmt->bind_param('i', $id);
            $stmt->execute();

            if($stmt->affected_rows > 0)
                header('Location: ?id_min='.$idMin);
            else
                header('Location: ?response=1&id_min='.$idMin);

            $stmt->close();
            $conn->close();
            exit();
        }

        $resPages = $conn->query("SELECT CEIL(COUNT(id) / $perPage) as pages FROM users");
        $row = $resPages->fetch_assoc();
        $maxPage = $row['pages'];
        $resPages->free();

        $stmt = $conn->prepare("SELECT * FROM users WHERE id BETWEEN ? AND ?");
        $stmt->bind_param('ii', $idMin, $idMax);
        $stmt->execute();
        $res = $stmt->get_result();

        $stmt->close();
        $conn->close();
	else:
?>
		<section class="ms-2">
            <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Utilizadores</h1>
			<table class="table table-striped table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Cidade</th>
                        <th>Rua</th>
                        <th>Código Postal</th>
                        <th>Administrador</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $res->fetch_assoc()):
                    ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['full_name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['local']) ?></td>
                                <td><?= htmlspecialchars($row['street']) ?></td>
                                <td><?= htmlspecialchars($row['cp']) ?></td>
                                <td><?= ($row['role'] == 'admin') ? 'Sim' : 'Não' ?></td>
                                <td class="d-flex gap-2 justify-content-center">
                                    <a href="<?= $basePath ?>/components/action_edit.php?id=<?= $row['id'] ?>&edit=true" class="btn btn-primary">Editar</a>
                                    <a href="?id=<?= $row['id'] ?>&delete=true" class="btn btn-danger" onclick="return confirm('Têm a certeza que quer eliminar este utilizador?')">Eliminar</a>
                                </td>
                            </tr>
                    <?php
                        endwhile;
                        $res->free();
                    ?>
                </tbody>
            </table>
            
                <?= (!empty($response) && $response == 1)
                    ? '<div class="d-flex justify-content-between">
                        <p class="text-danger">Não pode remover este utilizador</p>'
                    : ''
                ?>
                <?php
                    if($maxPage>1){
                ?>
                        <div class="d-flex gap-2 justify-content-end align-items-center">
                            <a href="?id_min=1" class="btn <?= ($currentPage == 1) ? 'btn-primary disabled' : '' ?>"><<</a>
                            <?php
                                if($currentPage > 2){
                            ?>
                                    <a href="?id_min=<?= $idMin - $perPage ?>"
                                    class="btn">
                                        <
                                    </a>
                            <?php
                                }
                            ?>

                            <a href="?id_min=<?= $idMin ?>" class="btn btn-primary disabled"><?= $currentPage ?></a>

                            <?php
                                if($currentPage < $maxPage -1){
                            ?>
                                    <a href="?id_min=<?= $idMin + $perPage ?>"
                                    class="btn">
                                        >
                                    </a>
                            <?php
                                }
                            ?>

                            <a href="?id_min=<?= $idMin + $perPage * ($maxPage - $currentPage) ?>"
                            class="btn <?= ($currentPage == $maxPage) ? 'btn-primary disabled' : '' ?>">
                                >>
                            </a>
                <?php
                    if(!empty($response) && $response == 1) echo '</div>';
                    }
                ?>
            </div>
		</section>
<?php
	endif;