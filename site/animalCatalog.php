<?php
    require_once('config.php');

    $pagina=1;

    if(isset($_GET['pagina'])){
        $pagina= filter_input(INPUT_GET, "pagina", FILTER_VALIDATE_INT);
    }
    if(!$pagina) $pagina=1;

    $limite=12;
    $inicio= ($pagina * $limite) - $limite;

    $registros= $config->query("SELECT COUNT(name) as ult FROM animals")->fetch_assoc()['ult'];
    $paginas= ceil($registros / $limite);

    $sql = "SELECT * FROM animals ORDER BY id ASC LIMIT $inicio, $limite";
    $res = $config->query($sql);
?>

<div class="container">
    <h1 class="text-center fw-bold mt-4 mb-5">Animais para adoção</h1>
</div>

<div class="container mb-4">
    <div class="row g-4 justify-content-center">
    <?php
    if ($res->num_rows > 0):
        foreach ($res as $animal):
            if ($animal['status'] == 'Disponível' || $animal['status'] == 'Em processo'):
                ?>
        <div class="col-12 col-md-6 col-lg-3 d-flex justify-content-center">
            <a href="animalDetails?id=<?= htmlspecialchars($animal['id']) ?>" class="card-link ">
                <?php $cor= $animal['gender'] === 'Macho'?'#89CFF0' : '#F48FB1' ?>
                <div class="card" style="border-color: <?=$cor?>;">
                    <div class="card-image">
                        <?php
                            $caminhoImagem=!empty($animal['image']) ? "assets/img/animals/". $animal['image'] : "assets/img/defaultAnimals.png";
                        ?>
                        <img class="photo img-fluid" src="<?=$caminhoImagem?>" alt="Foto de <?= htmlspecialchars($animal['name']) ?> ">
                    </div>
                    <div class="card-info">
                        <h3 class="fw-semibold"><?= htmlspecialchars($animal['name']) ?></h3>
                        <p class="fw-semibold"><?= htmlspecialchars($animal['id']) ?></p>
                    </div>
                </div>
            </a>
        </div>
        <?php endif;
        endforeach;
        else:
            echo "<p>Ainda não temos animais para adoção.</p>";
        endif; ?>
        </div>
</div>

<div class="d-flex justify-content-center">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="?pagina=1">Primeira</a></li>
            <?php if($pagina>1):?>
            <li class="page-item"><a class="page-link" href="?pagina=<?= $pagina-1 ?>">&laquo;</a></li>
            <?php endif; ?>
            <li class="page-item"><a class="page-link" href=""><?= $pagina?></a></li>
            <?php if($pagina<$paginas):?>
            <li class="page-item"><a class="page-link" href="?pagina=<?= $pagina+1 ?>">&raquo;</a></li>
            <?php endif; ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?= $paginas ?>">Última</a></li>
        </ul>
    </nav>
</div>

