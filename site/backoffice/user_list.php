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
			<table class="table table-striped table-hover" id="userList">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Cidade</th>
                        <th>Rua</th>
                        <th>Código Postal</th>
                        <th>Administrador</th>
                        <th>Ações</th>
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
                                    <a href="<?= $basePath ?>/components/action_edit.php?id=<?= $row['id'] ?>&edit=true"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="?id=<?= $row['id'] ?>&delete=true"  onclick="return confirm('Têm a certeza que quer eliminar este utilizador?')"><i style="color: #dc3545;" class="fa-solid fa-trash"></i></a>
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