<?php
    if(!$rerun):
        $metaTitle = 'Perfil do Veterinário';
        $metaDescription = 'Perfil do Veterinário';
    else:
        $vet= $conn->query("SELECT * FROM veterinarians");

?>
<section class="ban">
    <h2> <strong>A nossa equipa veterinária</strong></h2>
</section>
<section class="mb-3">
        <div class="container"> 
            <div class="row g-4 d-flex justify-content-center">
                <?php if($vet-> num_rows> 0): ?>
                <?php foreach($vet as $item): ?>
                <div class="card col-10 col-md-4 ms-3 me-3 text-white custom-bg-light-blue cards-vet">
                    <div class="card-image  mb-3 d-flex justify-content-center">
                            <?php
                                $caminhoImagem=!empty($item['photo']) ? "assets/img/vet/". $item['photo'] : "assets/img/defaultVet.png";
                            ?>
                            <img class="photo img-fluid img-vet" src="<?=$caminhoImagem?>" alt="Foto de <?= htmlspecialchars($item['name']) ?> ">
                        </div>
                    <div>                    
                    <p class="d-flex justify-content-center">Nome: <?= htmlspecialchars($item['name'])?></p>
                    </div>
                    <p class="d-flex justify-content-center">Especialidade:  <?= htmlspecialchars($item['specialty'])?></p>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    
</section>

<?php endif;?>