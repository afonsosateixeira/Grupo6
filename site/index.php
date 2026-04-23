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

		case 'cookies':
			$metaTitle = 'Política de Cookies';
			$metaDescription = 'Política de Cookies de Poppy and Max';
			break;

		case 'animalCatalog':
			$metaTitle = 'Catálogo de Animais';
			$metaDescription = 'Animais disponíveis para adoção';
			break;

		case 'adoptionGuide':
			$metaTitle = 'Guia de Adoção';
			$metaDescription = 'Guia passo a passo para adoção responsável';
			break;

		case 'contactos':
			$metaTitle = 'Contactos';
			$metaDescription = 'Contactos da Poppy and Max';
      break;

		case 'animal_care':
			$metaTitle = 'Cuidados animais';
			$metaDescription = 'Informação de vacinas para saúde animal';
      break;

		case 'animalDetails':
			$metaTitle = 'Detalhes';
			$metaDescription = 'Todas as informações do animal';
			break;

		case 'login':
			$metaTitle = 'Entrar';
			$metaDescription = 'Acesso à conta';
			break;

		case 'regist':
			$metaTitle = 'Registar';
			$metaDescription = 'Criar nova conta';
			break;

		case 'privacy':
			$metaTile = 'Politicas de Privacidade';
			$metaDescription = 'Politcas de Privacidade';
			break;

		case 'dia_voluntario':
			$metaTitle = 'Dia no abrigo';
			$metaDescription = 'Um dia como voluntário';
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
		<?php require_once 'components/header.html';
			switch ($route) {
				case 'index': ?>
					<section id="banner">
						<div>
							<h1>Onde novos começos ganham patas e corações</h1>
							<p>Conectando corações e promovendo o bem-estar animal através da adoção responsável e apoio comunitário</p>
							<a href="./index" class="btn btn-outline-primary">Quero Adotar</a>
							<a href="./index" class="btn btn-outline-primary">Torna-te num voluntário</a>
						</div>
					</section>

					<main class="container my-5">
						<section>
							<h2>Encontre o seu novo Melhor Amigo</h2>
							<div>
								<div>
									<img src="assets/img/Mike.png" alt="Foto da Yara">
									<p>Yara</p>
								</div>
								<div>
									<img src="assets/img/Mike.png" alt="Foto do Zeus">
									<p>Zeus</p>
								</div>
								<div>
									<img src="assets/img/Mike.png" alt="Foto do Mike">
									<p>Mike</p>
								</div>
							</div>
							<div>
								<p>Adotar é um ato de amor mas também de responsabilidade. Antes de levar um amigo para casa confira o nosso Guia de Adoção responsável para garantir que você e o seu animal sejam felizes para sempre.</p>
								<a href="./adoptionGuide" class="btn btn-outline-primary">Guia de Adoção</a>
							</div>
						</section>

						<section>
							<h2>Cuidar e Protejer: A nossa Missão com a Comunidade</h2>
							<div>
								<div>
									<h3>Prevenir é o maior ato de cuidado</h3>
									<img>
									<p>Não espere por sinais de dor</p>
									<a href="./index" class="btn btn-outline-primary">Agendar Check-up</a>
								</div>
								<div>
									<h3>Mural de Desaparecidos</h3>
									<img>
									<p>Viu por aí este animal?</p>
									<a href="./index" class="btn btn-outline-primary">Reunir famílias</a>
								</div>
							</div>
						</section>

						<section>
							<h2>A nossa Comunidade e Eventos</h2>
							<p>Não perca o próximo evento do Poppy and Max que irá decorrer no dia 5 de Maio pois nós também não</p>
							<!--Carossel from bootstrap-->
						</section>
						<section>
							<h2>Conheça os nossos parceiros</h2>
							<!-- Conteúdo dependente da página de parceiros-->
						</section>
					</main>
		<?php
					break;

				case 'cookies':
					require_once 'cookies.html';
					break;

				case 'animalCatalog':
					require_once 'animalCatalog.php';
					break;

				case 'adoptionGuide':
					require_once 'adoptionGuide.php';
					break;

				case 'contactos':
					require_once 'contactos.html';
	     			break;

				case 'animal_care':
					require_once 'animal_care.php';
	      			break;

				case 'animalDetails':
					require_once 'animalDetails.php';
					break;

				case 'login':
					require_once 'login.php';
					break;

				case 'regist':
					require_once 'regist.php';
					break;

				case 'privacy':
					require_once 'privacy.html';
	     			break;

				case 'dia_voluntario':
					require_once 'dia_voluntario.html';
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
		<?php require_once 'components/footer.html'; ?>
	</body>
</html>