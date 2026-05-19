<?php
    if(!$rerun):
        $metaTitle = 'Listagem Voluntários';
        $metaDescription = 'Listar Voluntários';
    else:
        $sql = "SELECT * FROM vw_volunteer_full_schedule";
        $lista = $conn->query($sql);

    while($voluntario = $lista->fetch_assoc()):
?>
    <div class="card" style="width: 18rem;">
    <div class="card-body text-center">
        <h3 class="card-title"><?= htmlspecialchars($voluntario['volunteer_name']) ?></h3>
        <p class="card-text text-start">Telemóvel: <?= htmlspecialchars($voluntario['phone']) ?></p>
        <p class="card-text text-start">Localidade: <?= htmlspecialchars($voluntario['city']) ?></p>
        <p class="card-text text-start">Horário:</p>
        <p class="card-text text-start">
        <?= htmlspecialchars($voluntario['day_week']) ?> – 
        <?= date('H:i', strtotime($voluntario['start_time'])) ?> até 
        <?= date('H:i', strtotime($voluntario['end_time'])) ?>
        </p>
    </div>
    </div>
<?php
endwhile;
endif;
?>