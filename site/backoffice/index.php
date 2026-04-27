<?php
	require_once("../config.php");

	$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') . '/';
	$path = basename($path);
	$path = pathinfo($path, PATHINFO_FILENAME);

	$route = ($path === 'backoffice' || $path === 'index') ? 'dashboard' : $path;

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
		<link rel="stylesheet" href="../assets/css/sidebar.css">
	</head>
	<body>
		<?php require_once("../components/sidebar.php");?>
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
						?>
						<section class="container my-5">
							<h1>404</h1>
							<p>Página não encontrada.</p>
						</section>
			<?php
						break;
				}
			?>
		</main>
	</body>
</html>