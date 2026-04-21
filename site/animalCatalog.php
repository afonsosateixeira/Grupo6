<?php
    require_once('config.php');

    $sql = "SELECT * FROM animals ORDER BY id ASC";
    $res = $config->query($sql);
?>

<div class="container-cards">
    <?php
    if ($res->num_rows > 0):
        foreach ($res as $animal):
            ?>
            <a href="animalDetails?id=<?= htmlspecialchars($animal['id']) ?>" class="card-link">
                <div class="card" >
                    <div class="card-image">
                        <img src="assets/img/animals/<?= $animal['image']; ?>"
                            alt="Foto de <?= htmlspecialchars($animal['name']) ?>">
                    </div>
                    <div class="card-info">
                        <h3><?= htmlspecialchars($animal['name']) ?></h3>
                        <p><?= htmlspecialchars($animal['id']) ?></p>
                    </div>
                </div>
            </a>
            <?php endforeach;
        else:
            echo "<p>Ainda não temos animais para adoção.</p>";
        endif; ?>
</div>
