<?php
	$backOffice = $backOffice ?? false;
	$metaTitle = $metaTitle ?? "";
	$metaDescription = $metaDescription ?? "";

	echo	'<meta charset="UTF-8">
			<meta name="description" content="'.$metaDescription.'">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>'.($backOffice ? 'Admin' : 'Poppy and Max').(!empty($metaTitle) ? ' | '.$metaTitle : '').'</title>
			<link rel="icon" type="image/png" href="'.$basePath.'/assets/img/favicon.png">
			<link rel="stylesheet" href="'.$basePath.'/assets/css/normalize.css">
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
			<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap">

			<link rel="stylesheet" href="'.$basePath.'/assets/css/styles.css">
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" defer integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
			<script src="'.$basePath.'/assets/js/scripts.js" defer></script>';
	if(file_exists(__DIR__."/../assets/css/".$route.".css"))
		echo '<link rel="stylesheet" href="'.$basePath.'/assets/css/'.$route.'.css">';
	if(file_exists(__DIR__."/../assets/js/".$route.".js"))
		echo '<script src="'.$basePath.'/assets/js/'.$route.'.js" defer></script>';
	