<?php
require_once('config.php');
$id = $_GET['id'] ?? null;

$sql = "select * from animals where id= $id";
$res = $config->query($sql);

$animal = $res->fetch_assoc();
?>

<section class="container m-3">
    <a href="animalCatalog" class="btn btn-secondary w-5"><i class="fa-solid fa-angle-left"></i></a>
</section>
<section class="mb-5 mt-5 d-flex justify-content-center">
    <div class="row bg-white card-animal w-100">
        <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
            <img class="photo img-fluid" src="assets/img/animals/<?= $animal['image']; ?>" alt="Foto de <?= htmlspecialchars($animal['name']) ?> ">
        </div>
        <div class="col-12 col-md-6 d-flex flex-column justify-content-center ">
            <h1 class="fw-bold"><?= htmlspecialchars($animal['name']) ?></h1>
            <p><strong>Raça: </strong><?= htmlspecialchars($animal['breed_id']) ?></p>
            <p><strong>Sexo: </strong><?= htmlspecialchars($animal['gender']) ?></p>
            <p><strong>Idade: </strong><?= htmlspecialchars($animal['birth_date']) ?></p>
            <!-- <p><strong>Porte: </strong><?= htmlspecialchars($animal['size']) ?></p> -->
            <p><strong>Estado: </strong><?= htmlspecialchars($animal['status']) ?></p>
            <p><?= htmlspecialchars($animal['description']) ?></p>
            <button class="btn-adopt w-50" onclick="abrirModalInteresse(<?= $animal['id']; ?>)">Adotar</button>
        </div>
    </div>
</section>
