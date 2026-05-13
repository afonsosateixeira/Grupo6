<?php
	# Declara a variável que identifica se a página está a ser lida pela segunda vez
	$rerun = $rerun ?? false;

	# Verifica se a página não existe na variável presente no config.php e verifica, no caso da página forbidden, se não foi parar a esta página através de um erro nesses casos identifica a pàgina como 404
	if(!in_array($route, PAGES[$backOffice]) || ($route == 'forbidden' && ($response != 401 && $response != 403)))
		$route = 404;

	# Chama a página correspondente
	if($backOffice && $route == 404)
		require '../'.$route.'.php';
	else
		require $route.'.php';

	# Mete a variável como verdadeira de forma a correr a segunda parte do código quando chamar a página a segunda vez
	$rerun = true;