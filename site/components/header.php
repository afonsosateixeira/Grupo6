<header>
  <nav class="navbar navbar-expand-lg bg-nav navbar-color">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= $basePath ?>/"
        ><img
          src="<?= $basePath?>/assets/img/logo.png"
          alt="Logo PAM"
          style="max-width: 120px; max-height: 50px; transform: translateX(-13px)"
      /></a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Adoção
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= $basePath ?>/animalCatalog">Catálogo de Animais</a></li>
              <li><a class="dropdown-item" href="<?= $basePath ?>/adoptionGuide">Guia de adoção</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Comunidade e Eventos
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= $basePath ?>/events">Calendário de Eventos</a></li>
              <li><a class="dropdown-item" href="#">Eventos Passados</a></li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li><a class="dropdown-item" href="<?= $basePath ?>/missing_animals">Animais Desaparecidos</a></li>
              <li><a class="dropdown-item" href="#">Encontrei um animal e agora?</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Apoio e saúde
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= $basePath ?>/donations">Doações</a></li>
              <li><a class="dropdown-item" href="#">Nossos Parceiros</a></li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li><a class="dropdown-item" href="<?= $basePath ?>/animal_care">Cuidados de Saúde</a></li>
              <li><a class="dropdown-item" href="<?= $basePath ?>/appointment">Marcação de Consultas</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Institucional
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= $basePath ?>/contactos">Contactos</a></li>
              <li><a class="dropdown-item" href="<?= $basePath ?>/dia_voluntario">Um dia no Abrigo</a></li>
              <li><a class="dropdown-item" href="<?= $basePath ?>/vetProfile">Perfil do Veterinário</a></li>
              <li><a class="dropdown-item" href="<?= $basePath ?>/perfis_voluntario">Perfil de Voluntário</a></li>
              <li><a class="dropdown-item" href="<?= $basePath ?>/sobrenos">Sobre Nós</a></li>
            </ul>
          </li>
        </ul>
        <?php
          if(empty($_SESSION['auth'])):
        ?>
            <div>
              <a href="<?= $basePath ?>/regist"><button class="btn-login" type="button">Registar</button></a>
              <a href="<?= $basePath ?>/login"><button class="btn-login btn-regist" type="button">Entrar</button></a>
            </div>
        <?php
          else:
        ?>
            <div class="d-flex align-items-center">
              <p class="mb-0">Bem vinda/o, <span class="fw-bold"><?= $_SESSION['user'] ?></span></p>
              <?php
                $stmt = $conn->prepare("SELECT 1 from notifications where user = ? AND status = 'not read'");
                $stmt->bind_param('i', $_SESSION['id_user']);
                $stmt->execute();
                $res = $stmt->get_result();

                $stmt->close();
                if($res->num_rows > 0):
              ?>
                  <a href="<?= $basePath ?>/notifications" ><i class="ms-1 fa fa-bell"></i></a>
              <?php
                endif;

                $stmt = $conn->prepare('SELECT email FROM users WHERE email = ? AND role = "admin"');
                $stmt->bind_param('s', $_SESSION['email']);
                $stmt->execute();
                $res = $stmt->get_result();

                if($row = $res->fetch_assoc()){
                  ?>
                  <a href="<?= $basePath ?>/backoffice"><button class="btn-login" type="button">Dashboard</button></a>
                  <?php
                }
                $stmt->close();
              ?>
              <a href="<?= $basePath ?>/logout"><button class="btn-login btn-logout" type="button">Sair</button></a>
            </div>
        <?php
          endif;
        ?>
      </div>
    </div>
  </nav>
</header>