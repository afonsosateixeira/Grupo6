<?php
require_once('config.php');
$id = $_GET['id'] ?? null;

$res = $config->query("select * from animals where id= $id");
$animal = $res->fetch_assoc();
?>

<section class="mb-5 mt-5 container">
    <div class="row">
        <div class="col-6">
            <img src="assets/img/animals/<?php echo $animal['image']; ?>" alt="Foto de <?php echo $animal['name']; ?>">
        </div>
        <div class="col-6">
            <h1><?php echo $animal['name']; ?></h1>
            <p><?php echo $animal['breed_id']?></p>
            <p><?php echo $animal['birth_date']?></p>
            <p><?php echo $animal['gender']?></p>
            <p><?php echo $animal['description']?></p>
            <p><?php echo $animal['status']?></p>
            <button class="btn btn-primary" onclick="abrirModalInteresse(<?php echo $animal['id']; ?>)">Adotar</button>
        </div>
    </div>
</section>