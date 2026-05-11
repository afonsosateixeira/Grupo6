<?php
	# Declara um título e uma descrição se a página ainda não os tinha recebido
	$metaTitle = $metaTitle ?? '';
	$metaDescription = $metaDescription ?? '';

	# Cria uma variável que identifica a pasta em que a página atual está para indicar as localizações de ficheiros corretas
	$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

	# Verifica se a página atual é de backoffice para indicar as localizações de ficheiros corretas
	if(!empty($backOffice)){
		$origin = $basePath;
		$basePath= $basePath.'../';
	} else
		$backOffice = false;
?>

<!-- Verifica o tipo de carácters, adiciona o titulo e a descrição(que dependem da página atual), adapta o tamanho da página ao ecrã e adiciona o icon da página -->
<meta charset="UTF-8">
<title><?= (!empty($metaTitle) ? $metaTitle.' | ' : '').($backOffice ? 'Admin' : 'Poppy and Max') ?></title>
<meta name="description" content="<?= $metaDescription ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="<?= $basePath ?>/assets/img/favicon.png">

<!-- Obtem fontes utilizadas -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap">

<!-- Obtem os estilos gerais -->
<link rel="stylesheet" href="<?= $basePath ?>/assets/css/normalize.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="<?= $basePath ?>/assets/css/styles.css">

<!-- Obtem os scripts gerais -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous" defer></script>
<script src="<?= $basePath ?>/assets/js/scripts.js" defer></script>

<?php
	# Verifica se exite um estilo específico da página e utiliza se existir
	if(file_exists(__DIR__."/../assets/css/".$route.".css"))
		echo '<link rel="stylesheet" href="'.$basePath.'/assets/css/'.$route.'.css">';

	# Verifica se exite um script específico da página e utiliza se existir
	if(file_exists(__DIR__."/../assets/js/".$route.".js"))
		echo '<script src="'.$basePath.'/assets/js/'.$route.'.js" defer></script>';

	# Após localizar todos os ficheiros corretamente reverte a variável, tenho de verificar se é necessário
	if($backOffice)
		$basePath = $origin;