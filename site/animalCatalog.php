<?php
    require_once('config.php');

    $sql = "SELECT * FROM animals ORDER BY id ASC";
    $lista = $config->query($sql);
?>

<div class="container-cards">
    <?php

    if ($lista->num_rows > 0):
        while ($animal = $lista->fetch_assoc()):
            ?>
            <a href="animalDetails?id=<?php echo $animal['id'];?>" class="card-link">
                <div class="card" >
                    <div class="card-image">
                        <img src="assets/img/animals/<?php echo $animal['image']; ?>"
                            alt="Foto de <?php echo $animal['name']; ?>">
                    </div>
                    <div class="card-info">
                        <h3><?php echo $animal['name']; ?></h3>
                        <p><?php echo $animal['id']; ?></p>
                    </div>
                </div>
            </a>
            <?php
        endwhile;
    else:
        echo "<p>Ainda não temos animais para adoção.</p>";
    endif;
    ?>
</div>
