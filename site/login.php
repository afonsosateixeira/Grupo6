<?php
	if(!$rerun):
		# Verifica se a página foi aberta através do formulário ser preenchido, atribuindo os valores preenchidos a variáveis
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$email = trim($_POST['email']);
			$pass = hash('sha512', trim($_POST['pass']));

			# Verifica se falta algum campo ser preenchido mandando um aviso se faltar, caso todos estiverem preenchidos verifica se existe algum resultado de um utilizador com o email inserido
			if(!empty($email) && !empty($pass)){
				$stmt = $conn->prepare('SELECT full_name, email, password FROM users WHERE email = ?');
				$stmt->bind_param('s', $email);
				$stmt->execute();
				$res = $stmt->get_result();

				# Se existir um utilizador onde o email seja igual ao inserido verifica a pass e inicia a sessão se esta também estiver correta, senão dá erros correspondentes
				if($row = $res->fetch_assoc()){
					if($row['password'] === $pass){
						$_SESSION['auth'] = true;
						$_SESSION['email'] = $row['email'];

						# Guarda o nome com apenas o primeiro e último nomes, se este existir, ou apenas o primeiro nome
						$name = preg_split('/\s+/', trim($row['full_name']));
						if(count($name) == 1)
							$name = $name[0];
						else
							$name = $name[0].' '.$name[count($name) -1];
						$_SESSION['user'] = $name;
					} else
						$response = '<p class="fw-bold mt-2 mb-0">Password incorreta!</p>';
				} else
					$response = '<p class="fw-bold mt-2 mb-0">Esse email não está registado!</p>';
			} else
				$response = '<p class="fw-bold mt-2 mb-0">Preencha todos os campos para entrar!</p>';
		}

		# Verifica se o utilizador já está autenticádo, se sim redireciona para a página inicial, dando prioridáde se tiver página de redirecionamento
		if(!empty($_SESSION['auth'])){
			if(!empty($_GET['redirect'])){
				header('Location: ./'.$_GET['redirect']);
				exit();
			} else {
				header('Location: ./');
				exit();
			}
		}

		$metaTitle = 'Iniciar Sessão';
		$metaDescription = 'Acesso à conta';
	else:
?>
		<section class="container my-5" style="max-width: 520px;">
			<h1 class="mb-4">Entrar</h1>
			<form method="POST" action="<?= (!empty($_GET['redirect'])) ? '?redirect='.$_GET['redirect'] : '' ?>" class="border rounded-3 p-4 bg-light">
				<div class="mb-3">
					<label class="form-label" for="email">Email</label>
					<input type="email" name="email" id="email" class="form-control" placeholder="email@exemplo.com">
				</div>
				<div class="mb-3">
					<label class="form-label" for="pass">Palavra-passe</label>
					<input type="password" name="pass" id="pass" class="form-control" placeholder="********">
				</div>
				<button type="submit" class="btn btn-primary w-100">Entrar</button>
				<?= $response ?>
			</form>
		</section>
<?php
    endif;