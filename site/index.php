<?php
	$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') . '/';
	$path = basename($path);
	$path = pathinfo($path, PATHINFO_FILENAME);

	$route = ($path === 'site') ? 'index' : $path;

	switch ($route) {
		case 'adoptionGuide':
			$metaTitle = 'Guia de Adoção';
			$metaDescription = 'Guia passo a passo para adoção responsável';
			break;

		case 'animal_care':
			$metaTitle = 'Cuidados animais';
			$metaDescription = 'Informação de vacinas para saúde animal';
      		break;

		case 'animalCatalog':
			$metaTitle = 'Catálogo de Animais';
			$metaDescription = 'Animais disponíveis para adoção';
			break;

		case 'animalDetails':
			$metaTitle = 'Detalhes'; #No caso de preferires podes tentar utilizar uma variável e pesquisar a base de dados para introduzir o nome do animal específico.
			$metaDescription = 'Todas as informações do animal';
			break;

		case 'contactos':
			$metaTitle = 'Contactos';
			$metaDescription = 'Contactos da Poppy and Max';
      		break;

		case 'cookies':
			$metaTitle = 'Política de Cookies';
			$metaDescription = 'Política de Cookies da Poppy and Max';
			break;

		case 'dia_voluntario':
			$metaTitle = 'Dia no Abrigo';
			$metaDescription = 'Um dia como voluntário';
			break;

		case 'index':
			$metaTitle = '';
			$metaDescription = 'Página inicial da Poppy and Max';
			break;

		case 'login':
			$metaTitle = 'Iniciar Sessão';
			$metaDescription = 'Acesso à conta';
			break;

		case 'privacy':
			$metaTile = 'Politicas de Privacidade';
			$metaDescription = 'Politcas de Privacidade da Poppy and Max';
			break;

		case 'regist':
			$metaTitle = 'Registar';
			$metaDescription = 'Criar conta';
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
		<?php require_once 'components/header.php'; ?>
			<main>
				<?php
					switch ($route) {
						case 'adoptionGuide':
							require_once 'adoptionGuide.php';
							break;

						case 'animal_care':
							require_once 'animal_care.php';
							break;

						case 'animalCatalog':
							require_once 'animalCatalog.php';
							break;

						case 'animalDetails':
							require_once 'animalDetails.php';
							break;

						case 'contactos':
							require_once 'contactos.html';
							break;

						case 'cookies':
							require_once 'cookies.html';
							break;

						case 'dia_voluntario':
							require_once 'dia_voluntario.html';
							break;

						case 'index':
							require_once 'home.php';
							break;

							case 'login':
							require_once 'login.php';
							break;

						case 'privacy':
							require_once 'privacy.html';
							break;

						case 'regist':
							require_once 'regist.php';
							break;

						default:
							?>
							<main class="container my-5">
								<h1>404</h1>
								<p>Página não encontrada.</p>
							</main>
				<?php
							break;
					}
				?>
			</main>
		<?php require_once 'components/footer.php'; ?>
	</body>
</html>