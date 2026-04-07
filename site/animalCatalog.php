<?php
    require_once('config.php');

    $sql = "SELECT * FROM animals ORDER BY id ASC";
    $lista = $config->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <?php
        $metaTitle = "Catálogo de Animais";
        $metaDescription = "";
        require_once "components/head.php";
    ?>
</head>

<body>
    <?php require_once("components/header.php");?>

    <div class="modal fade" id="formModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-paw me-3"></i>
                        Estou Interessado
                    </h5>
                </div>
                <form action="action_interest.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="animal_id" id="modal_animal_id">
                        <div class="mb-3">
                            <label for="nome" class="form-label fw-bold">Nome</label>
                            <input type="text" name="full_name" placeholder="Ex: André" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="text" name="email" placeholder="Ex: andre@gmail.com" class="form-control"required>
                        </div>
                        <div class="mb-3">
                            <label for="tele" class="form-label fw-bold">Telemóvel</label>
                            <input type="number" name="phone" placeholder="Ex: 911 922 922" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <a href="animalCatalog.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="btnEnviar" class="btn btn-primary px-4">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container-cards">
        <?php

        if ($lista->num_rows > 0):
            while ($animal = $lista->fetch_assoc()):
                ?>
                <div class="card size">
                    <div class="card-image">
                        <img src="assets/img/animals/<?php echo $animal['image']; ?>"
                            alt="Foto de <?php echo $animal['name']; ?>">
                    </div>
                    <div class="card-info">
                        <h3><?php echo $animal['name']; ?></h3>
                        <p>ID: #<?php echo $animal['id']; ?></p>

                        <button class="btn btn-outline-secondary" onclick="abrirModalInteresse(<?php echo $animal['id']; ?>)">
                            <i class="fa fa-heart"></i>
                        </button>
                    </div>
                </div>
                <?php
            endwhile;
        else:
            echo "<p>Ainda não temos animais para adoção.</p>";
        endif;
        ?>
    </div>
    <?php require_once("components/footer.php");?>
    <script src="assets/js/modalForm.js"></script>
</body>

</html>