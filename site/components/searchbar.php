<?php

$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);    
}

if( !empty($search)){
    $stmt = $config->prepare("SELECT * FROM animals WHERE name LIKE '$search%' OR id LIKE '%$search%' ORDER BY id ASC");
    $stmt->execute();
    $res = $stmt->get_result();
}

if(empty($search)){
    $search ="";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/searchbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Document</title>
</head>

<body>
    <div class="position-relative">
        <form action="" method="get">
            <i class="fas fa-search search1"></i>
            <input type="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Pesquisar..." class="search ">
            <i class="fas fa-filter filter1"></i>
        </form>
    </div>
</body>

</html>