<?php
    if(!$rerun):
        require_once 'components/helpers.php';

        $id = $_GET['id'] ?? null;
        if(!$id || !is_numeric($id)){
            header(("location:animalCatalog"));
            exit();
        }

        $metaTitle = "Detalhes" ;
        $metaDescription = 'Todas as informações do animal';
    else:
        $stmt= $conn->prepare("SELECT a.*, b.name AS breed_name , s.name AS specie_name from animals a LEFT JOIN breeds b ON a.breed_id= b.id LEFT JOIN species s ON a.specie_id= s.id where a.id= ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $animal= $stmt->get_result()->fetch_assoc();
?>
        <section class="container m-3">
            <a href="animalCatalog" class="btn btn-secondary w-5"><i class="fa-solid fa-angle-left"></i></a>
        </section>

        <section class="mb-5 d-flex justify-content-center">
            <div class="row bg-white card-animal w-100">
                <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
                    <?php
                        $caminhoImagem=!empty($animal['image']) ? "assets/img/animals/". $animal['image'] : "assets/img/defaultAnimals.png";
                    ?>
                    <img class="photo img-fluid" src="<?= htmlspecialchars($caminhoImagem)?>" alt="Foto de <?= htmlspecialchars($animal['name']) ?> ">
                </div>

                <div class="col-12 col-md-6 d-flex flex-column justify-content-center ">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <h1 class="fw-bold"><?= htmlspecialchars($animal['name']) ?></h1>
                        <span class="badge bg-secondary"><?= htmlspecialchars($animal['specie_name']) ?></span>
                    </div>
                    <p><strong>Raça: </strong><?= mostrarValor($animal['breed_name']) ?></p>
                    <p><strong>Sexo: </strong><?= htmlspecialchars($animal['gender']) ?></p>
                    <p><strong>Idade: </strong><?= mostrarIdade($animal['birth_date']) ?></p>
                    <p><strong>Porte: </strong><?= mostrarValor($animal['size']) ?></p>
                    <p class="text-break mt-3"><?php if(!empty($animal['description'])){
                            echo htmlspecialchars($animal['description']);
                        }?>
                    </p>
                    <button class="btn-adopt w-50" onclick="abrirModalInteresse(<?= $animal['id']; ?>)">Adotar</button>
                </div>
            </div>
        </section>
<?php
    endif;