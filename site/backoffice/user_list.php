<?php
	if(!$rerun):
		$metaTitle = 'Lista de Útilizadores';
		$metaDescription = 'Lista de Útilizadores da Poppy and Max';

        if(!empty($_GET['delete']) && !empty($_GET['id'])){
            $id = $_GET['id'];

            $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
            $stmt->bind_param('i', $id);
            $stmt->execute();

            if($stmt->affected_rows > 0)
                header('Location: user_list');
            else
                header('Location: ./user_list?response=1');

            $stmt->close();
            $conn->close();
            exit();
        }

        $query = $conn->query("SELECT * FROM users");
	else:
?>
		<section class="ms-2">
            <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Utilizadores</h1>
			<table class="table table-striped table-hover text-center align-middle" id="userList">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">Id</th>
                        <th scope="col" class="text-center">Nome</th>
                        <th scope="col" class="text-center">Email</th>
                        <th scope="col" class="text-center">Telefone</th>
                        <th scope="col" class="text-center">Cidade</th>
                        <th scope="col" class="text-center">Rua</th>
                        <th scope="col" class="text-center">Código Postal</th>
                        <th scope="col" class="text-center">Administrador</th>
                        <th scope="col" class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($query as $row):
                    ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['full_name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= !empty($row['local']) ? htmlspecialchars($row['local']) : '' ?></td>
                                <td><?= !empty($row['street']) ? htmlspecialchars($row['street']) : '' ?></td>
                                <td><?= !empty($row['cp']) ? htmlspecialchars($row['cp']) : '' ?></td>
                                <td><?= ($row['role'] == 'admin') ? 'Sim' : 'Não' ?></td>
                                <td>
                                    <a href="<?= $basePath ?>/components/action_edit.php?id=<?= $row['id'] ?>&edit=true" class="btn btn-primary">Editar</a>
                                    <a href="?id=<?= $row['id'] ?>&delete=true" class="btn btn-danger" onclick="return confirm('Têm a certeza que quer eliminar este utilizador?')">Eliminar</a>
                                </td>
                            </tr>
                    <?php
                        endforeach;
                    ?>
                </tbody>
            </table>
            
                <?= (!empty($response) && $response == 1)
                    ? '<div class="d-flex justify-content-between">
                        <p class="text-danger">Não pode remover este utilizador</p>'
                    : ''
                ?>
		</section>
<?php
	endif;