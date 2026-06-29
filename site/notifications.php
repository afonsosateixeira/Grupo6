<?php
	if(!$rerun):
		if(empty($_SESSION['auth'])){
			header('Location: ./');
			exit();
		}

		if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_GET['delete'])){
			$stmt = $conn->prepare('DELETE FROM notifications WHERE id = ?');
			$stmt->bind_param('i', $_GET['id']);
			$stmt->execute();

			$stmt->close();

			header('Location: notifications');
			exit();
		}

		$metaTitle = 'Notificações';
		$metaDescription = 'Página de notificações do utilizador';

	else:
		$stmt = $conn->prepare('SELECT * FROM notifications WHERE user = ? ORDER BY status DESC, date DESC');
		$stmt->bind_param('i', $_SESSION['id_user']);
		$stmt->execute();
		$res = $stmt->get_result();

		$stmt->close();
		date_default_timezone_set('Europe/Lisbon');
?>
		<section class="container my-5">
			<form action="" method="POST" class="d-flex justify-content-between align-items-center flex-wrap">
				<h1>Notificações</h1>
				<input name="date" class="d-none" value="<?= date('Y-m-d H:i:s') ?>">
				<button type="submit" class="btn btn-success" onclick="return confirm('Têm a certeza que quer marcar as mensagens como lidas?')">Marcar como lidas</button>
			</form>
			<?php
				if($res->num_rows > 0):
			?>
					<table class="table">
						<thead>
							<tr>
								<th>Tipo</th>
								<th>Assunto</th>
								<th>Data</th>
								<th>Eliminar</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$read = [];
								while($row = $res->fetch_assoc()):
									$read[] = $row['id'];
							?>
									<tr class="<?= $row['status'] == 'read' ? 'table-active' : 'table-'.$row['color'] ?>">
										<th><?= ($row['type'] == 'adoption') ? 'Adoção' : 'Voluntariádo' ?></th>
										<td><?= htmlspecialchars($row['title']) ?></td>
										<td><?= $row['date'] ?></td>
										<td><a href="?id=<?= $row['id'] ?>&delete" onclick="return confirm('Têm a certeza que quer eliminar esta notificação?')"><i style="color: #dc3545;" class="fa-solid fa-trash"></i></a></td>
									</tr>
								<?php
									endwhile;
									if($_SERVER['REQUEST_METHOD'] === 'POST'){
										$date = $_POST['date'] ?? '';
										$dateCheck = DateTime::createFromFormat('Y-m-d H:i:s', $date);
										if($dateCheck && $dateCheck->format('Y-m-d H:i:s') === $date && !empty($read)){
											$placeholder = implode(',', array_fill(0, count($read), '?'));
											$type = 's'.str_repeat('i', count($read));

											$stmt = $conn->prepare("UPDATE notifications SET status = 'read' WHERE date <= ? AND id IN ($placeholder)");
											$stmt->bind_param($type, $date, ...$read);
											$stmt->execute();

											$stmt->close();
											echo "<script>window.location.href='notifications';</script>";
											exit();
										}
									}
								?>
						</tbody>
					</table>
			<?php
				else:
			?>
					<p>Não têm notificações para ler</p>
			<?php
				endif;
			?>
		</section>
<?php
	endif;