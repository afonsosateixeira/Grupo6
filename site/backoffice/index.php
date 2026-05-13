<?php
	# Inicia a sessão e faz ligação à base de dados 
	require_once '../db.php';

	# Chama funções
	require_once("../components/helpers.php");

	# Declara uma variável para indicar que as páginas são de back office
	$backOffice = true;

	# Vai buscar as variáveis que identificam a página atual, faz logout, faz redirect se necessário(por exemplo um formulário precisa de login, fazem login e automáticamente retorna à página), inicia as variáveis backOffice(identifica se a página é de Back Office) e response (guarda mensagens como por exemplo erros) e verifica se o utilizador está autenticado e se têm permissões antes de poder aceder a páginas restritas
	require_once '../components/routing.php';

	# Chama a página correta automáticamente, assumindo que esta está presente num array em config.php(caso contrário vai para a página 404)
	require '../components/rerun.php';
?>

<!DOCTYPE html>
<html lang="pt">
	<head>
		<?php
			# Vai buscar o código todo que útilizamos para o head como para chamar o css, javascript, fontes e outras bibliotécas
			require_once "../components/head.php";
		?>

		<!-- Chama o estilo da sidebar -->
		<link rel="stylesheet" href="<?= $basePath ?>/assets/css/sidebar.css">
	</head>
	<body>
		<?php
			# Vai buscar a sidebar do back office
			require_once 'components/sidebar.php';
		?>
		<main>
			<?php
				# Chama a página correta automáticamente, assumindo que esta está presente num array em config.php(caso contrário vai para a página 404)
				require '../components/rerun.php';
			?>
		</main>
	</body>
</html>