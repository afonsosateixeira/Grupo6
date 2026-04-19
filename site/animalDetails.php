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


    <!--Modal-->
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
                        <a href="animalDetails?id=<?php echo $animal['id']; ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="btnEnviar" class="btn btn-primary px-4">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="assets/js/modalForm.js"></script>