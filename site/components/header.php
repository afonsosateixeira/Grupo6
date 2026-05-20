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
              <li><a class="dropdown-item" href="<?= $basePath ?>/events"">Calendário de Eventos</a></li>
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
              <li><a class="dropdown-item" href="#">Sobre Nós</a></li>
            </ul>
          </li>
        </ul>
        <a href="<?= $basePath ?>/regist"><button class="btn-login" type="button">Registar</button></a>
        <a href="<?= $basePath ?>/login"><button class="btn-login btn-regist" type="button">Entrar</button></a>
      </div>
    </div>
  </nav>
</header>