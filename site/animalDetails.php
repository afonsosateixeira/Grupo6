<?php
require_once 'config.php';
require_once 'components/helpers.php';

$id = $_GET['id'] ?? null;
if(!$id || !is_numeric(($id))){
    header(("location:animalCatalog.php"));
    exit();
}
$stmt= $config->prepare("SELECT a.*, b.name AS breed_name from animals a LEFT JOIN breeds b ON a.breed_id= b.id where a.id= ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res= $stmt->get_result();
$animal = $res->fetch_assoc();

?>

<section class="container m-3">
    <a href="animalCatalog" class="btn btn-secondary w-5"><i class="fa-solid fa-angle-left"></i></a>
</section>
<section class="mb-5 d-flex justify-content-center">
    <div class="row bg-white card-animal w-100">
        <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
            <img class="photo img-fluid" src="assets/img/animals/<?= $animal['image']; ?>" alt="Foto de <?= htmlspecialchars($animal['name']) ?> ">
        </div>
        <div class="col-12 col-md-6 d-flex flex-column justify-content-center ">

            <h1 class="fw-bold"><?= htmlspecialchars($animal['name']) ?></h1>
            <p><strong>Raça: </strong><?= htmlspecialchars($animal['breed_name']) ?></p>
            <p><strong>Sexo: </strong><?= mostrarValor($animal['gender']) ?></p>
            <p><strong>Idade: </strong><?= mostrarIdade($animal['birth_date']) ?></p>
            <p><strong>Porte: </strong><?= mostrarValor($animal['size']) ?></p>
            <p><strong>Estado: </strong><?= htmlspecialchars($animal['status']) ?></p>
            <p><?php if(!empty($animal['description'])){
                    echo htmlspecialchars($animal['description']);
                }?>
            </p>

            <button class="btn-adopt w-50" onclick="abrirModalInteresse(<?= $animal['id']; ?>)">Adotar</button>
        </div>
    </div>
</section>
