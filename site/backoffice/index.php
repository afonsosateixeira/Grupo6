<?php
	# Inicia a sessão e faz ligação à base de dados 
	require_once '../db.php';

	# Vai buscar a última parte do url(a página atual)
	$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') . '/';
	$path = basename($path);
	$path = pathinfo($path, PATHINFO_FILENAME);

	#Verifica se a página atual devia ficar como index ou como identificado anteriormente
	$route = ($path === 'backoffice' || $path === 'index') ? 'dashboard' : $path;

	# No caso de ser necessário usar uma mensagem
	$response = $_GET['response'] ?? '';

	if(empty($_SESSION['auth'])){
		header('Location: ../forbidden?response=401');
		exit();
	} else {
		$stmt = $conn->prepare('SELECT email, role FROM users WHERE email = ?');
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
		$res = $stmt->get_result();

		if($row = $res->fetch_assoc()){
			if($row['role'] != 'admin'){
				header('Location: ../forbidden?response=403');
				exit();
			}
		} else {
			session_destroy();
			header('Location: ../forbidden?response=401');
			exit();
		}
	}

	switch ($route) {
		case 'adoptionProcess':
			$metaTitle = '';
			$metaDescription = 'Guia passo a passo para adoção responsável';
			break;

		case 'animalList':
			$metaTitle = '';
			$metaDescription = 'Guia passo a passo para adoção responsável';
			break;

		case 'dashboard':
			$metaTitle = '';
			$metaDescription = 'Guia passo a passo para adoção responsável';
			break;

		default:
			http_response_code(404);
			$metaTitle = 'Página não encontrada';
			$metaDescription = 'A página que procura não existe';
			break;
	}
?>

<!DOCTYPE html>
<html lang="pt">
	<head>
		<?php
			$backOffice = true;
			require_once "../components/head.php";
		?>
		<link rel="stylesheet" href="<?= $basePath ?>/assets/css/sidebar.css">
	</head>
	<body>
		<?php require_once 'components/sidebar.php'; ?>
		<main>
			<?php
				switch ($route) {
					case 'adoptionProcess':
						require_once 'adoptionProcess.php';
						break;

					
					case 'animalList':
						require_once 'animalList.php'; 
						break;

					
					case 'dashboard':
						require_once 'dashboard.php';
						break;

					default:
						require_once '../404.html';
						break;
				}
			?>
		</main>
	</body>
</html>