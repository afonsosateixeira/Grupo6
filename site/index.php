<?php
	$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

	if ($basePath !== '' && $basePath !== '/' && str_starts_with($path, $basePath))
		$path = substr($path, strlen($basePath));

	$route = trim($path, '/');

	if ($route === '')
		$route = 'index';

	if (str_contains($route, '.'))
		$route = pathinfo($route, PATHINFO_FILENAME);

	switch ($route) {
		case 'index':
			$metaTitle = '';
			$metaDescription = 'Página inicial da Poppy and Max';
			break;

		case 'animalCatalog':
			$metaTitle = 'Catálogo de Animais';
			$metaDescription = 'Animais disponíveis para adoção';
			break;

		case 'adoptionGuide':
			$metaTitle = 'Guia de Adoção';
			$metaDescription = 'Guia passo a passo para adoção responsável';
			break;

		case 'login':
			$metaTitle = 'Entrar';
			$metaDescription = 'Acesso à conta';
			break;

		case 'regist':
			$metaTitle = 'Registar';
			$metaDescription = 'Criar nova conta';
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
		<?php require_once 'components/head.php'; ?>
	</head>
	<body>
		<?php require_once 'components/header.html'; ?>
		<main>
			<?php
			switch ($route) {
				case 'index':
					?>
					<section class="container my-5">
						<div class="p-5 rounded-4 bg-light border">
							<h1 class="mb-3">Poppy and Max</h1>
							<p class="mb-4">Bem-vindo ao nosso site de adoção. Aqui pode conhecer animais disponíveis e seguir o guia de adoção.</p>
							<div class="d-flex gap-2 flex-wrap">
								<a href="./animalCatalog" class="btn btn-primary">Ver Catálogo</a>
								<a href="./adoptionGuide" class="btn btn-outline-primary">Ler Guia de Adoção</a>
							</div>
						</div>
					</section>
					<?php
					break;

				case 'animalCatalog':
					require_once 'animalCatalog.php';
					break;

				case 'adoptionGuide':
					require_once 'adoptionGuide.php';
					break;

				case 'login':
					require_once 'login.php';
					break;

				case 'regist':
					require_once 'regist.php';
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
		<?php require_once 'components/footer.html'; ?>
	</body>
</html>