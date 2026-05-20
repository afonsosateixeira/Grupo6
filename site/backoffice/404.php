<?php
	# A primeira vez que o código corre declara variáveis com o título e a descrição da página
	if(!$rerun):
		http_response_code(404);
		$metaTitle = 'Página não encontrada';
		$metaDescription = 'A página que procura não existe';
	# Na segunda vez que o código corre mostra o conteúdo todo da página
	else:
?>
		<section class="container my-5">
			<h1>404</h1>
			<p>Página não encontrada.</p>
		</section>
<?php
	endif;