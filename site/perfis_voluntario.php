  <div class="container">
<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!$rerun):
      $metaTitle = 'Perfis de voluntarios';
      $metaDescription = 'Regista-te para seres voluntário';

    else:
      if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true):
        
    ?>
      <div class="text-center my-5">
        <h1>Perfil dos voluntários</h1>
      </div>
    <?php
    endif; // 1. Fecha o: if ($perfil_existente) ... else
    endif;   // 2. Fecha o: if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) ... else
    ?>
  </div>