<?php
	$currentPage = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_FILENAME);
	echo	'<meta charset="UTF-8">
			<meta name="description" content="'.$metaDescription.'">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Poppy & Max | '.$metaTitle.'</title>
			<link rel="icon" type="image/png" href="assets/img/icon.png">
			<link rel="stylesheet" href="assets/css/normalize.css">
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
			<link rel="stylesheet" href="assets/css/styles.css">
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" defer integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
			<script src="assets/js/scripts.js" defer></script>';
	if(file_exists("assets/css/".$currentPage.".css"))
		echo '<link rel="stylesheet" href="assets/css/'.$currentPage.'.css">';
	if(file_exists("assets/js/".$currentPage.".js"))
		echo '<script src="assets/js/'.$currentPage.'.js" defer></script>';