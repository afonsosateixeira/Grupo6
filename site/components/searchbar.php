<?php
    $search = "";
    if (isset($_GET['search'])) {
        $search = trim($_GET['search']);    
    }

    if( !empty($search)){
        $stmt = $conn->prepare("SELECT * FROM animals WHERE name LIKE '$search%' OR id LIKE '%$search%' ORDER BY id ASC");
        $stmt->execute();
        $res = $stmt->get_result();
    }

    if(empty($search)){
        $search ="";
    }
?>

<div class="position-relative">
    <form action="" method="get">
        <i class="fas fa-search search1"></i>
        <input type="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Pesquisar..." class="search ">
        <i class="fas fa-filter filter1"></i>
    </form>
</div>