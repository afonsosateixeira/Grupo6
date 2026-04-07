<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/adoptionGuide.css">
    <title>Guia de Adoção</title>
</head>

<body>
    <?php include('components/header.php'); ?>

    <main class="container my-5">
        <section class="hero-section bg-primary text-white rounded-4 p-5 mb-5 shadow-lg">
            <div class="text-center">
                <h1 class="fw-bold mb-3"><i class="fa-solid fa-paw me-3"></i>Como Adotar</h1>
                <p>Seu guia passo a passo para uma adoção responsável e feliz.</p>
            </div>
        </section>

        <section class="mb-5">
            <h2 class="mb-4 fw-bold text-center">Passos para Adotar</h2>
            <div class="row g-4">
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card adoption-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="badge bg-warning text-dark mb-3 fs-5">1</div>
                            <h5 class="card-title fw-bold">Explore o Catálogo</h5>
                            <p class="card-text">Navegue pelos animais disponíveis. Veja fotos, descrições e personalidades de cada um.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card adoption-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="badge bg-warning text-dark mb-3 fs-5">2</div>
                            <h5 class="card-title fw-bold">Escolha seu Animal</h5>
                            <p class="card-text">Encontre o animal que combina com seu estilo de vida, espaço e personalidade.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card adoption-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="badge bg-warning text-dark mb-3 fs-5">3</div>
                            <h5 class="card-title fw-bold">Registre Interesse</h5>
                            <p class="card-text">Preencha o formulário de interesse com seus dados para iniciar o processo.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card adoption-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="badge bg-warning text-dark mb-3 fs-5">4</div>
                            <h5 class="card-title fw-bold">Visite o Abrigo</h5>
                            <p class="card-text">Venha pessoalmente conhecer o animal e conversar com nossa equipe.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card adoption-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="badge bg-warning text-dark mb-3 fs-5">5</div>
                            <h5 class="card-title fw-bold">Preencha Documentos</h5>
                            <p class="card-text">Complete a papelada necessária e assine o termo de adoção responsável.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card adoption-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="badge bg-warning text-dark mb-3 fs-5">6</div>
                            <h5 class="card-title fw-bold">Leve para Casa</h5>
                            <p class="card-text">Seu novo amigo está pronto! Leve-o para seu lar preparado e amoroso.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <h2 class="mb-4 fw-bold text-center">Cuidados Pós-Adoção</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card adoption-card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Ambiente Seguro</h5>
                            <p class="card-text">Mantenha rotinas diárias consistentes. Crie um espaço calmo para adaptação.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card adoption-card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Vínculo Afetivo</h5>
                            <p class="card-text">Construa confiança com paciência. Use reforço positivo no treinamento.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card adoption-card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Saúde Veterinária</h5>
                            <p class="card-text">Agende check-ups regulares. Monitore saúde e comportamento.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="mb-5">
            <div class="card responsibility-card border-0 shadow-sm">
                <div class="card-header">
                    <h4 class="card-title mb-0 fw-bold"><i class="fa-solid fa-shield-alt me-2"></i>Responsabilidades da Adoção</h4>
                </div>
                <div class="card-body">
                    <p><strong>Antes da adoção:</strong> Avalie com seriedade se seu estilo de vida, espaço e recursos financeiros permitem cuidar adequadamente de um animal. Considere alergias familiares, disponibilidade de tempo e custos veterinários contínuos.</p>
                    <p><strong>Durante o processo:</strong> Seja completamente honesto sobre suas condições de vida. Não adote por impulso ou para presentear terceiros sem consulta prévia.</p>
                    <p><strong>Depois da adoção:</strong> Comprometa-se com cuidados permanentes - alimentação adequada, exercícios diários, saúde veterinária regular e amor incondicional. Devolver um animal adotado é um ato de irresponsabilidade grave.</p>
                    <hr>
                    <p class="mb-0 fw-bold text-blue">Adotar é assumir uma responsabilidade permanente. Garanta que está verdadeiramente preparado para oferecer um lar estável e amoroso.</p>
                </div>
            </div>
        </section>

    </main>

    <?php include('components/footer.php'); ?>
</body>

</html>