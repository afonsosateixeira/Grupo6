<section id="banner">
    <div>
        <h1>Onde novos começos ganham patas e corações</h1>
        <p class="mt-2 mb-3">Conectando corações e promovendo o bem-estar animal através da adoção responsável e apoio comunitário</p>
        <div>
            <a href="<?= $basePath ?>/" class="btn btn-outline-primary">Quero Adotar</a>
            <a href="<?= $basePath ?>/" class="btn btn-outline-primary">Torna-te num voluntário</a>
        </div>
    </div>
</section>

<section class="container my-5 text-center">
    <section>
        <h2 class="custom-blue fw-bold fs-3">Encontre o seu novo Melhor Amigo</h2>
        <div class="d-flex flex-row justify-content-center gap-2">
            <div class="">
                <img src="<?= $basePath ?>/assets/img/Mike.png" class="" alt="Foto da Yara">
                <p>Yara</p>
            </div>
            <div class="">
                <img src="<?= $basePath ?>/assets/img/Mike.png" class="" alt="Foto do Zeus">
                <p>Zeus</p>
            </div>
            <div class="">
                <img src="<?= $basePath ?>/assets/img/Mike.png" class="" alt="Foto do Mike">
                <p>Mike</p>
            </div>
        </div>
        <div>
            <p>Adotar é um ato de amor mas também de responsabilidade. Antes de levar um amigo para casa confira o nosso Guia de Adoção responsável para garantir que você e o seu animal sejam felizes para sempre.</p>
            <a href="<?= $basePath ?>/adoptionGuide" class="btn btn-outline-primary">Guia de Adoção</a>
        </div>
    </section>

    <section>
        <h2 class="custom-blue fw-bold fs-3">Cuidar e Protejer<br>A nossa Missão com a Comunidade</h2>
        <div class="d-flex flex-row justify-content-center gap-2">
            <div class="">
                <h3>Prevenir é o maior ato de cuidado</h3>
                <img>
                <p>Não espere por sinais de dor</p>
                <a href="<?= $basePath ?>/" class="btn btn-outline-primary">Agendar Check-up</a>
            </div>
            <div class="">
                <h3>Mural de Desaparecidos</h3>
                <img>
                <p>Viu por aí este animal?</p>
                <a href="<?= $basePath ?>/" class="btn btn-outline-primary">Reunir famílias</a>
            </div>
        </div>
    </section>

    <section>
        <h2 class="custom-blue fw-bold fs-3">A nossa Comunidade e Eventos</h2>
        <p>Não perca o próximo evento do Poppy and Max que irá decorrer no dia 5 de Maio pois nós também não</p>
        <div id="eventCarousel" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="<?= $basePath ?>/assets/img/animal_care_dog.png" class="d-block w-100" alt="Caõminhada 2026">
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

    <section>
        <h2 class="custom-blue text-center fw-bold fs-3">Conheça os nossos parceiros</h2>
        <!-- Conteúdo dependente da página de parceiros-->
    </section>
</section>