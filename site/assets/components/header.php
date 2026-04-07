<?php
require_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-nav navbar-color">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img src="assets/img/logo.png" alt="Logo PAM" style="width: 60px;"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Adoção
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="animalCatalog.php">Catálogo de Animais</a></li>
                                <li><a class="dropdown-item" href="adoptionGuide.php">Guia de adoção</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Comunidade e Eventos
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Calendário de Enventos</a></li>
                                <li><a class="dropdown-item" href="#">Eventos Passados</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Animais desaparecidos</a></li>
                                <li><a class="dropdown-item" href="#">Encontrei um animal e agora?</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Apoio e saúde
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Top Doadores</a></li>
                                <li><a class="dropdown-item" href="#">Nossos Parceiros</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Marcação de consultas</a></li>
                                <li><a class="dropdown-item" href="#">Cuidados de saúde</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Institucional
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Um dia no abrigo</a></li>
                                <li><a class="dropdown-item" href="#">Perfil de voluntário</a></li>
                            </ul>
                        </li>
                    </ul>
                    <button class="btn-login" type="submit">Registar</button>  
                    <a href="dashboard.php"><button class="btn-login btn-regist" type="submit">Entrar</button></a>
                    
                </div>
            </div>
        </nav>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>