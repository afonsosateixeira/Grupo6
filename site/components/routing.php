<?php
	# Vai buscar a última parte do url(a página atual)
	$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
	$path = basename($path);
	$path = pathinfo($path, PATHINFO_FILENAME);

	# Declara a variável de back office no caso de não ter vindo do back office
	$backOffice = $backOffice ?? false;

	# Verifica se o utilizador está a tentar aceder à página de backoffice sem estár autenticado, redirecionando para forbidden nesse caso
	if($backOffice && empty($_SESSION['auth'])){
		header('Location: ../forbidden?response=401');
		exit();
	}

	# Verifica se o utilizador está autenticado quando tenta aceder à página de Back Office e se encontra uma conta correspondente
	if($backOffice && !empty($_SESSION['auth'])){
		$stmt = $conn->prepare('SELECT email, role FROM users WHERE email = ?');
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();

		$res = $stmt->get_result();

		$row = $res->fetch_assoc();

		$res->free();
		$stmt->close();

		# No caso da conta não ter permissões de admin redireciona para forbidden
		if($row['role'] != 'admin'){
			header('Location: ../forbidden?response=403');
			exit();
		}
	}

	#Verifica se a página atual devia ficar como home/dashboard (dependendo se back office ) ou como identificado anteriormente
	if($backOffice)
		$route = ($path === 'backoffice' || $path === 'index') ? 'dashboard' : $path;
	else
		$route = ($path === 'site' || $path === '' || $path === 'index') ? 'home' : $path;

	# Destroi a sessão e redireciona para o login no caso de fazer logout
	if($route == 'logout') {
		session_destroy();
		header('Location: '.($backOffice ? '.' : '').'./login');
		exit();
	}

	# No caso de ser necessário usar uma mensagem
	$response = $_GET['response'] ?? '';