<?php
    $search = "";
    if (isset($_GET['search'])) {
        $search = trim($_GET['search']);    
    }

    if( !empty($search)){
        $searchNome= $search . '%';
        $searchId= '%' . $search . '%';
        
        $group= prepareQuery($conn, 'SELECT * FROM animals WHERE name LIKE ? OR id LIKE ? ORDER BY id ASC','ss', $searchNome, $searchId )->get_result();
    }

?>

<div class="position-relative">
    <form action="" method="get">
        <i class="fas fa-search search1"></i>
        <input type="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Pesquisar..." class="search ">
        <i class="fas fa-filter filter1"></i>
    </form>
</div>