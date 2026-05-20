<?php
    if(!$rerun):
            $metaTitle = 'Catálogo de Animais';
            $metaDescription = 'Animais disponíveis para adoção';
    else:
        $pagina=1;

        if(isset($_GET['pagina'])){
            $pagina= filter_input(INPUT_GET, "pagina", FILTER_VALIDATE_INT);
        }
        if(!$pagina) $pagina=1;

        $limite=12;
        $inicio= ($pagina * $limite) - $limite;

        $registros= $conn->query("SELECT COUNT(*) as ult FROM animals WHERE status='Disponível' OR status='Em processo'")->fetch_assoc()['ult'];
        $paginas= ceil($registros / $limite);

        $stmt = $conn->prepare("SELECT * FROM animals WHERE status='Disponível' OR status='Em processo' ORDER BY id ASC LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limite, $inicio);
        $stmt->execute();
        $res = $stmt->get_result();
?>
        <div class="container">
            <h1 class="text-center fw-bold mt-4 mb-4">Animais para adoção</h1>
        </div>

        <div class="container d-flex justify-content-center mb-4">
          <?php include('components/searchbar.php'); ?>
        </div>

        <div class="container mb-4">
            <div class="row g-4 justify-content-center">
                <?php
                    if ($res->num_rows > 0):
                        foreach ($res as $animal):
                ?>
                            <div class="col-12 col-md-6 col-lg-3 d-flex justify-content-center">
                                <a href="animalDetails?id=<?= $animal['id'] ?>" class="card-link ">
                                    <?php $cor= $animal['gender'] === 'Macho'?'#89CFF0' : '#F48FB1' ?>
                                    <div class="card" style="border-color: <?=$cor?>;">
                                        <div class="card-image">
                                            <?php
                                                $caminhoImagem=!empty($animal['image']) ? "assets/img/animals/". $animal['image'] : "assets/img/defaultAnimals.png";
                                            ?>
                                            <img class="photo img-fluid" src="<?= htmlspecialchars($caminhoImagem)?>" alt="Foto de <?= htmlspecialchars($animal['name']) ?> ">
                                        </div>
                                        <div class="card-info">
                                            <h3 class="fw-semibold"><?= htmlspecialchars($animal['name']) ?></h3>
                                            <p class="fw-semibold"><?= $animal['id'] ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                <?php
                        endforeach;
                    else:
                        echo "<p>Ainda não temos animais para adoção.</p>";
                    endif;
                ?>
            </div>
        </div>
        <?php include('components/pagination.php'); ?>
<?php
    endif;