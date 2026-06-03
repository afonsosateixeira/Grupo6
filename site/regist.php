<?php
	if(!$rerun):
		# Verifica se a página foi aberta através do formulário ser preenchido, atribuindo os valores preenchidos a variáveis
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$name = trim($_POST['name']);
			$email = trim($_POST['email']);
			$pass = hash('sha512', trim($_POST['pass']));
			$contact = trim($_POST['number']);

			# Verifica se falta algum campo ser preenchido mandando um aviso se faltar, caso todos estarem preenchidos verifica se o email inserido é igual ao que o utilizador está a tentar registar
			if(!empty($name) && !empty($email) && !empty($pass) && !empty($contact)){
				$stmt = $conn->prepare('SELECT email FROM users WHERE email = ?');
				$stmt->bind_param('s', $email);
				$stmt->execute();
				$res = $stmt->get_result();

				# Se existir algum email igual dá um aviso, se não cria uma conta e inicia a sessão com a mesma
				if($res->num_rows > 0)
					$response = '<p class="fw-bold mt-2 mb-0">Esse email já está em uso!</p>';
				else{
					$stmt = $conn->prepare('INSERT INTO users(full_name, email, password, phone) VALUES(?, ?, ?, ?)');
					$stmt->bind_param('ssss', $name, $email, $pass, $contact);
					$stmt->execute();

					$_SESSION['auth'] = true;
					$_SESSION['email'] = $email;

					# Guarda o nome com apenas o primeiro e último nomes, se este existir, ou apenas o primeiro nome
					$name = preg_split('/\s+/', htmlspecialchars(trim($name)));
					$name[0] = mb_convert_case($name[0], MB_CASE_TITLE, 'UTF-8');
					if(count($name) === 1)
						$name = $name[0];
					else{
						$name[1] = mb_convert_case(end($name), MB_CASE_TITLE, 'UTF-8');
						$name = $name[0].' '.$name[1];
					}

					$_SESSION['user'] = $name;
				}
			} else
				$response = '<p class="fw-bold mt-2 mb-0">Preencha todos os campos de registo!</p>';
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

		$metaTitle = 'Registar';
		$metaDescription = 'Crie a sua conta';
	else:
?>
		<section class="container d-flex align-items-center justify-content-center vh-100 vw-100">
			<div>
				<h1 class="mb-4"><span class="fw-semibold">Registar</span> / <a href="<?= $basePath ?>/login" class="">Entrar</a></h1>
				<form method="POST" action="<?= (!empty($_GET['redirect'])) ? '?redirect='.$_GET['redirect'] : '' ?>" class="border rounded-3 p-4 bg-light">
					<div class="mb-3 ms-3 me-2">
						<a href="<?= $basePath ?>/" class="d-flex justify-content-between align-items-center">
							<img src="<?= $basePath?>/assets/img/logo.png" alt="Logo PAM"
					        style="max-width: 120px; max-height: 50px; transform: translateX(-13px)"/>
						    <span class="btn btn-primary">Voltar</span>
						</a>
					</div>
					<div class="mb-3">
						<label class="form-label" for="name">Nome</label>
						<input type="text" name="name" id="name" class="form-control" placeholder="Nome completo">
					</div>
					<div class="mb-3">
						<label class="form-label" for="email">Email</label>
						<input type="email" name="email" id="email" class="form-control" placeholder="email@exemplo.com">
					</div>
					<div class="mb-3">
						<label class="form-label" for="pass">Palavra-passe</label>
						<input type="password" name="pass" id="pass" class="form-control" placeholder="********">
					</div>
					<div class="mb-3">
						<label class="form-label" for="phone">Telemóvel</label>
						<input type="text" name="number" id="phone" class="form-control" placeholder="+351 999999999">
					</div>
					<!-- Maybe add a button as an option to add more stuff such as birthday/etc-->
					<button type="submit" class="btn btn-primary w-100">Criar conta</button>
					<?= $response ?>
				</form>
			</div>
		</section>
<?php
    endif;