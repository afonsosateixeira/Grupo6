<section id="banner">
    <div class="container d-flex align-items-center h-100">
        <div class="bannerContents">
            <h1 class="fs-3 fw-bold text-white">Onde novos começos ganham patas e corações</h1>
            <p class="mt-2 mb-4 fw-semibold text-white">Conectando corações e promovendo o bem-estar animal através da adoção responsável e apoio comunitário</p>
            <div class="d-flex column-gap-4">
                <a href="<?= $basePath ?>/" class="btn custom-bg-orange text-white">Quero Adotar</a>
                <a href="<?= $basePath ?>/" class="btn custom-bg-white rounded-pill text-black">Torna-te num voluntário</a>
            </div>
        </div>
    </div>
</section>

<section class="container text-center">
    <section class="py-4">
        <h2 class="custom-blue fw-bold fs-3">Encontre o seu novo Melhor Amigo</h2>
        <div class="d-flex flex-row flex-wrap justify-content-center gap-4 my-4">
            <div class="box-pink">
                <img src="<?= $basePath ?>/assets/img/home_yara.jpg" class="rounded-top-4" alt="Foto da Yara">
                <p class="pt-2 pb-3">Yara</p>
            </div>
            <div class="box-blue">
                <img src="<?= $basePath ?>/assets/img/home_zeus.webp" class="rounded-top-4" alt="Foto do Zeus">
                <p class="pt-2 pb-3">Zeus</p>
            </div>
            <div class="box-blue">
                <img src="<?= $basePath ?>/assets/img/home_mike.avif" class="rounded-top-4" alt="Foto do Mike">
                <p class="pt-2 pb-3">Mike</p>
            </div>
        </div>
        <div>
            <p class="fs-6 mx-auto custom-w-1">Adotar é um ato de amor mas também de responsabilidade. Antes de levar um amigo para casa confira o nosso Guia de Adoção responsável para garantir que você e o seu animal sejam felizes para sempre.</p>
            <a href="<?= $basePath ?>/adoptionGuide" class="btn custom-bg-orange text-white rounded-pill mt-2">Guia de Adoção</a>
        </div>
    </section>

    <section class="py-4">
        <h2 class="custom-blue fw-bold fs-3 mb-3">Cuidar e Protejer: A nossa Missão com a Comunidade</h2>
        <div class="row column-gap-3 row-gap-3 justify-content-center">
            <div class="col-auto">
                <div class="communityCard mx-auto flex-grow-1 py-1 px-2 rounded-4">
                    <h3 class="custom-blue fw-semibold fs-5">Prevenir é o maior ato de cuidado</h3>
                    <img src="<?= $basePath ?>/assets/img/home_animal_care.png" alt="Icon Cuidados Animais">
                    <p class="fs-6">Não espere por sinais de dor</p>
                    <a href="<?= $basePath ?>/" class="btn custom-btn custom-bg-orange text-white rounded-3 mt-2">Agendar Check-up</a>
                </div>
            </div>
            <div class="col-auto">
                <div class="communityCard mx-auto flex-grow-1 py-1 px-2 rounded-4">
                    <h3 class="custom-blue fw-semibold fs-5">Mural de Desaparecidos</h3>
                    <img src="<?= $basePath ?>/assets/img/home_lost_animals.png" alt="Icon Animais Desaparecidos">
                    <p class="fs-6">Viu por aí este animal?</p>
                    <a href="<?= $basePath ?>/" class="btn custom-btn custom-bg-orange text-white mt-2">Reunir famílias</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-3">
        <h2 class="custom-blue fw-bold fs-3">A nossa Comunidade e Eventos</h2>
        <p class="mx-auto fs-6 custom-w-2">Não perca o próximo evento do Poppy and Max que irá decorrer no dia 5 de Maio, pois nós também não!</p>
        <div id="eventCarousel" class="carousel slide mt-2">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="<?= $basePath ?>/assets/img/dia_voluntario_banner1.png" class="d-block w-100" alt="Caõminhada 2026">
                </div>
                <div class="carousel-item">
                <img src="<?= $basePath ?>/assets/img/animal_care_cat.png" class="d-block w-100" alt="Cãominhada 2025">
                </div>
                <div class="carousel-item">
                <img src="<?= $basePath ?>/assets/img/animal_care_rabies.png" class="d-block w-100" alt="Cãominhada 2024">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section class="pt-2 pb-5">
        <h2 class="custom-blue text-center fw-bold fs-3">Conheça os nossos parceiros</h2>
        <!-- Conteúdo dependente da página de parceiros-->
    </section>
</section>