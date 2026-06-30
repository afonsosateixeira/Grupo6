<?php
	if(!$rerun):
		$metaTitle = 'Animais Perdidos';
		$metaDescription = 'Lista de animais perdidos';

        $add = $_GET['add'] ?? '';

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $actionUserId = $_SESSION['id_user'] ?? null;
            $actionName = trim($_POST['name'] ?? null);
            $actionSeen = trim($_POST['seen'] ?? null);
            $actionPhone = trim($_POST['phone'] ?? null);
            $actionLocal = trim($_POST['local'] ?? null);

            $file = "";

            if (!empty($_FILES['image']['name'])) {
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file = uniqid('lost_', true) . '.' . $extension;

                if (!move_uploaded_file($_FILES['image']['tmp_name'], $folder . $file)) {
                    header("Location: ../missing_animals?status=erro_imagem");
                    exit();
                }
            }

            if($actionUserId != null && $actionName != null && $actionSeen != null && $actionPhone != null && $actionLocal != null){
                $stmt=$conn->prepare("INSERT INTO lost_animals (user_id, animal_name, last_seen_date, contact_phone, location, photo) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("isssss",$actionUserId, $actionName, $actionSeen, $actionPhone, $actionLocal, $file);
                $stmt->execute();
                header("Location: ./missing_animals?status=criado");
            } else
                header("Location: ./missing_animals?status=erro_validacao");
            exit();
        }

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
        $resA = $stmt->get_result();

        $stmt->close();
	else:
?>
		<section id="banner" class="d-flex justify-content-center align-items-center">
			<h1 class="text-center text-light fw-bold px-2">Animais Desaparecidos</h1>
		</section>

        <section class="container mb-5 px-4 mt-3">
            <?php
                if(isset($_SESSION['auth']) && $_SESSION['auth']):
            ?>
                    <section id="addForm" class="d-none">
                        <div class="d-flex justify-content-between">
                            <h2 class="custom-blue fw-bold">Reportar animal como desaparecido</h2>
                            <button class="btn-close" onclick="toggleForm('close')"></button>
                        </div>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formName" class="form-label fw-bold">Nome do Animal Perdido</label>
                                        <input id="formName" type="text" name="name" class="form-control" placeholder="Ex: Boby" required maxlength="100">
                                    </div>

                                    <div class="mb-3">
                                        <label for="formSince" class="form-label fw-bold">Perdido desde</label>
                                        <input id="formSince" type="date" name="seen" class="form-control" required max="<?= date('Y-m-d'); ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="formLocation" class="form-label fw-bold">Fotografia do Animal</label>
                                        <input id="formLocation" type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formPhone" class="form-label fw-bold">Contacto</label>
                                        <input id="formPhone" type="text" name="phone" class="form-control" placeholder="Ex: +351 900000001" required maxlength="20">
                                    </div>

                                    <div class="mb-3">
                                        <label for="formLocation" class="form-label fw-bold">Perdido em</label>
                                        <input id="formLocation" type="text" name="local" class="form-control" placeholder="Ex: Lisboa" required maxlength="255">
                                    </div>

                                    <div class="mb-3">
                                        <label for="formSubmit" class="form-label fw-bold">Submeter processo</label>
                                        <button id="formSubmit" type="submit" class="btn btn-primary d-block w-100" onclick="">Reportar como desaparecido</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>

                    <div id="filters" class="d-flex justify-content-end mb-4">
                        <button class="btn btn-primary" onclick="toggleForm('open')">Reportar como desaparecido</button>
                    </div>

            <?php
                endif;
            ?>

            <div class="row gap-3 justify-content-center">
                <?php
                    while($row = $resA->fetch_assoc()):
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