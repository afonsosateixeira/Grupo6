  <div class="container">
<?php
    if (!$rerun):
      $metaTitle = 'Perfis de voluntarios';
      $metaDescription = 'Regista-te para seres voluntário';
    else:
      $sql = "SELECT * FROM vw_volunteer_simple_schedule";
      $lista = $conn->query($sql);
    ?>
      <div class="text-center my-5">
        <h1>Perfil dos voluntários</h1>
      </div>
        <div class="cartas">
<?php
    while($voluntario = $lista->fetch_assoc()):
?>
    <div class="card" style="width: 18rem">
    <div class="card-body text-center">
        <h3 class="card-title"><?= htmlspecialchars($voluntario['volunteer_name']) ?></h3>
        <p class="card-text text-start">Horário:
        <?= htmlspecialchars($voluntario['day_week']) ?> – 
        <?= date('H:i', strtotime($voluntario['start_time'])) ?> até 
        <?= date('H:i', strtotime($voluntario['end_time'])) ?>
        </p>
    </div>
    </div>
<?php
  endwhile;
?>
    </div>
<?php
  endif;
?>
  </div>