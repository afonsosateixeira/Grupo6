<!-- require once config.php quando tivermos a usar a base de bados por completo -->
<!DOCTYPE html>
<html lang="pt">
	<head>
		<?php
			$metaTitle = ""; //Nesta variável insiram o título da página, exemplo "Guia de Adoção" resultando em "Poppy & Max | Guia de Adoção"
			$metaDescription = "Descrição da página web"; // Nesta variável insiram a descrição do site por exemplo "Guia que demonstra o nosso processo de adoção na Poppy & Max"
			require_once "components/head.php";
			//Se tiverem css extra ou javascript da página adicionem aqui (apenas para funções extra)
		?>
	</head>
	<body>
		<?php require_once "components/header.html";?>
		<!-- Se vocês quizerem usarem banner full width começem o banner aqui e metam o resto do conteúdo da página em baixo -->
		<main class="container">
			<!-- Conteúdo da página, e banner se não quizerem full width -->
		</main>
		<?php require_once "components/footer.html";?>
	</body>
</html>