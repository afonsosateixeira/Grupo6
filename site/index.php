<?php
	# Inicia a sessão e faz ligação à base de dados, este documento também chama o config.php que inicia variáveis gerais como as que identificam as páginas que existem no site
	require_once 'db.php';

	# Vai buscar as variáveis que identificam a página atual, faz logout, faz redirect se necessário(por exemplo um formulário precisa de login, fazem login e automáticamente retorna à página), inicia as variáveis backOffice(identifica se a página é de Back Office) e response (guarda mensagens como por exemplo erros) e verifica se o utilizador está autenticado e se têm permissões antes de poder aceder a páginas restritas
	require_once 'components/routing.php';

	# Chama a página correta automáticamente, assumindo que esta está presente num array em config.php(caso contrário vai para a página 404)
	require 'components/rerun.php';
?>

<!DOCTYPE html>
<html lang="pt">
	<head>
		<?php
			# Vai buscar o código todo que útilizamos para o head como para chamar o css, javascript, fontes e outras bibliotécas
			require_once 'components/head.php';

			# Obtem o estilo para a searchbar para páginas que necessitam desta
			if($route == 'animalCatalog')
				echo '<link rel="stylesheet" href="'.$basePath.'/assets/css/searchbar.css">';
		?>
	</head>
	<body>
		<?php
			# Vai buscar o nosso header/navbar
			require_once 'components/header.php';
		?>
		<main>
			<?php
				# Chama a página correta automáticamente, assumindo que esta está presente num array em config.php(caso contrário vai para a página 404)
				require 'components/rerun.php';
			?>
		</main>
	<?php
		# Vai buscar o nosso footer
		require_once 'components/footer.php';
	?>
	</body>
</html>