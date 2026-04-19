<?php
 require_once("../config.php");
	$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

	if ($basePath !== '' && $basePath !== '/' && str_starts_with($path, $basePath))
		$path = substr($path, strlen($basePath));

	$route = trim($path, '/');

	if ($route === '')
		$route = 'index';

	if (str_contains($route, '.'))
		$route = pathinfo($route, PATHINFO_FILENAME);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <?php
        $metaTitle = "";
        $metaDescription = "";
        $backOffice = true;
        require_once "../components/head.php";
    ?>
    <link rel="stylesheet" href="../assets/css/sidebar.css">
</head>
<body>
    <?php require_once("../components/sidebar.html");?>
</body>
</html>