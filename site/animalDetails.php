<?php
require_once('config.php');
$id = $_GET['id'] ?? null;

$sql = "select * from animals where id= $id";
$res = $config->query($sql);

$animal = $res->fetch_assoc();
?>

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
            <button class="btn w-50" onclick="abrirModalInteresse(<?= $animal['id']; ?>)">Adotar</button>
        </div>
    </div>

    <!--Modal
        <div class="modal fade" id="formModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-paw me-3"></i>
                        Estou Interessado
                    </h5>
                </div>
                <form action="backoffice/action_interest.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="animal_id" id="modal_animal_id">
                        <div class="mb-3">
                            <label for="nome" class="form-label fw-bold">Nome</label>
                            <input type="text" name="full_name" placeholder="Ex: André" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="text" name="email" placeholder="Ex: andre@gmail.com" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="tele" class="form-label fw-bold">Telemóvel</label>
                            <input type="number" name="phone" placeholder="Ex: 911 922 922" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <a href="animalDetails?id=<?= $animal['id']; ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="btnEnviar" class="btn btn-primary px-4">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    -->
</section>
<script src="assets/js/modalForm.js"></script>