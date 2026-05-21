<?php
	if(!$rerun):
		$metaTitle = 'Animais Perdidos';
		$metaDescription = 'Lista de animais perdidos';

        $perPage = 12;
        $idMin = $_GET['id_min'] ?? 0;
        $idMax = $idMin + $perPage;
        $currentPage = $idMax / $perPage;

        $resPages = $conn->query("SELECT CEIL(COUNT(id) / $perPage) as pages FROM vw_lost_pets_radar");
        $row = $resPages->fetch_assoc();
        $maxPage = $row['pages'];
        $resPages->free();

        $stmt = $conn->prepare("SELECT * FROM vw_lost_pets_radar ORDER BY id ASC LIMIT ? OFFSET ?");
        $stmt->bind_param('ii', $perPage, $idMin);
        $stmt->execute();
        $res = $stmt->get_result();

        $stmt->close();
        $conn->close();
	else:
?>
		<section id="banner" class="d-flex justify-content-center align-items-center">
			<h1 class="text-center text-light fw-bold px-2">Animais Desaparecidos</h1>
		</section>

        <section class="container my-5 px-4">
            <div class="row gap-3 justify-content-center">
                <?php
                    while($row = $res->fetch_assoc()):
                ?>
                    <div class="card bg-body-secondary col-auto text-center py-3 align-items-center">
                        <h3 class="fw-bold <?= ($row['found'] == 'Yes') ? 'custom-blue' : 'text-danger' ?>"><?= ($row['found'] == 'Yes') ? 'Encontrado' : 'Perdido' ?></h3>
                        <img src="assets/img/lost/<?= !empty($row['photo']) ? htmlspecialchars($row['photo']) : 'default_lost.png' ?>" class="card-img" alt="Foto do <?= htmlspecialchars($row['animal']) ?>">
                        <div class="card-body pb-0">
                            <p class="text-primary fw-bold"><?= htmlspecialchars($row['animal']) ?></p>
                            <p><span class="fw-bold">Desde: </span><?= $row['since'] ?></p>
                            <p class="mb-0"><span class="fw-bold">Onde: </span><?= htmlspecialchars($row['location']) ?></p>
                        </div>
                    </div>
                <?php
                    endwhile;
                ?>
            </div>
            <?php
                if($maxPage>1){
            ?>
                    <div class="d-flex gap-2 justify-content-end align-items-center">
                        <a href="?id_min=0" class="btn <?= ($currentPage == 1) ? 'disabled' : '' ?>"><<</a>
                        <?php
                            if($currentPage > 1){
                        ?>
                                <a href="?id_min=<?= $idMin - $perPage ?>"
                                class="btn">
                                    <?= $currentPage -1 ?>
                                </a>
                        <?php
                            }
                        ?>

                        <a href="?id_min=<?= $idMin ?>" class="btn btn-primary disabled"><?= $currentPage ?></a>

                        <?php
                            if($currentPage < $maxPage){
                        ?>
                                <a href="?id_min=<?= $idMin + $perPage ?>"
                                class="btn">
                                    <?= $currentPage +1 ?>
                                </a>
                        <?php
                            }
                        ?>

                        <a href="?id_min=<?= $idMin + $perPage * ($maxPage - $currentPage) ?>"
                        class="btn <?= ($currentPage == $maxPage) ? 'disabled' : '' ?>">
                            >>
                        </a>
                <?php
                    }
                ?>
        </section>
<?php
	endif;