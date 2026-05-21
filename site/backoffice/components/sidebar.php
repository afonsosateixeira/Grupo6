<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar-pam"
    style="width: 280px; height: 100vh; position: fixed; left: 0; top: 0; z-index: 1050; box-shadow: 4px 0 10px rgba(0,0,0,0.1);">
    <a href="<?= $basePath ?>/index" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="fa-solid fa-paw me-2 fs-4"></i>
        <span class="fs-4 fw-bold">PAM</span>
    </a>
    <hr>

    <ul class="nav nav-pills flex-column flex-grow-1">
        <li class="nav-item mb-4">
            <a href="#" class="nav-link text-white d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" data-bs-target="#menuPessoal" aria-expanded="true">
                <span><i class="fa-solid fa-users me-2"></i>Gestão Pessoal</span>
                <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i>
            </a>
            <div class="collapse show" id="menuPessoal">
                <ul class="nav flex-column submenu mt-1">
                    <li><a href="<?= $basePath ?>/user_list" class="nav-link">Utilizadores</a></li>
                    <li><a href="<?= $basePath ?>/listagemvoluntarios" class="nav-link">Voluntários</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item mb-4">
            <a href="#" class="nav-link text-white d-flex justify-content-between align-items-center collapsed"
                data-bs-toggle="collapse" data-bs-target="#menuAnimais" aria-expanded="false">
                <span><i class="fa-solid fa-dog me-2"></i> Gestão de Animais</span>
                <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i>
            </a>
            <div class="collapse" id="menuAnimais">
                <ul class="nav flex-column submenu mt-1">
                    <li><a href="<?= $basePath ?>/missing_animals" class="nav-link">Animais Perdidos</a></li>
                    <li><a href="<?= $basePath ?>/animalList" class="nav-link">Animais</a></li>
                    <li><a href="<?= $basePath ?>/adoptionProcess" class="nav-link">Processo Adoção</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item mb-4">
            <a href="#" class="nav-link text-white d-flex justify-content-between align-items-center collapsed"
                data-bs-toggle="collapse" data-bs-target="#menuSaudeFinanca" aria-expanded="false">
                <span><i class="fa-solid fa-briefcase-medical me-2"></i>Gestão de Saúde e Finanças</span>
                <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i>
            </a>
            <div class="collapse" id="menuSaudeFinanca">
                <ul class="nav flex-column submenu mt-1">
                    <li><a href="<?= $basePath ?>/appointmentList" class="nav-link">Consultas</a></li>
                    <li><a href="<?= $basePath ?>/vetList" class="nav-link">Veterinários</a></li>
                    <li><a href="<?= $basePath ?>/donationList" class="nav-link">Doações</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item mb-4">
            <a href="#" class="nav-link text-white d-flex justify-content-between align-items-center collapsed"
                data-bs-toggle="collapse" data-bs-target="#menuEventos" aria-expanded="false">
                <span><i class="fa-solid fa-calendar-days me-2"></i> Gestão de Eventos</span>
                <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i>
            </a>
            <div class="collapse" id="menuEventos">
                <ul class="nav flex-column submenu mt-1">
                    <li><a href="<?= $basePath ?>/eventsList" class="nav-link">Eventos</a></li>
                </ul>
            </div>
        </li>
    </ul>

    <hr>

    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?= $basePath ?>/assets/img/default_user.png" alt="Foto do Utilizador" width="32" height="32" class="rounded-circle me-2">
            <strong><?= $_SESSION['user'] ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <!-- <li><a class="dropdown-item" href="#">Definições</a></li>
            <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li>
            <hr class="dropdown-divider">
            </li> -->
            <li><a class="dropdown-item text-white" href="<?= $basePath ?>/../logout">Sair</a></li>
        </ul>
    </div>
</div>