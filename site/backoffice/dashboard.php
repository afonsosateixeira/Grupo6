<?php
	# A primeira vez que o código corre declara variáveis com o título e a descrição da página
	if(!$rerun):
		$metaTitle = '';
		$metaDescription = 'Dashboard da Poppy and Max';
	# Na segunda vez que o código corre mostra o conteúdo todo da página
	else:
?>
		<section>
			<h1>Dashboard</h1>
		</section>
<?php
	endif;