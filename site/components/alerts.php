<?php
$status = $_GET['status'] ?? '';

$mapaStatus = [
    'criado' => ['Registo criado com sucesso!', 'alert-success'],
    'editado' => ['Registo editado com sucesso!', 'alert-success'],
    'apagado' => ['Registo eliminado com sucesso!', 'alert-danger'],
    'eliminado' => ['Registo eliminado com sucesso!', 'alert-danger'],
    'iniciado' => ['O seu processo de adoção foi iniciado!', 'alert-success'],
    'cancelado' => ['O seu processo de adoção foi cancelado.', 'alert-warning'],
    'erro_validacao' => ['Dados inválidos no formulário. Preencha todos os campos corretamente.', 'alert-danger'],
    'status_alterado' => ['Estado atualizado com sucesso!', 'alert-success'],
    'erro_imagem' => ['Erro ao carregar a imagem. Verifique o formato e o tamanho.', 'alert-warning']
];

if (isset($mapaStatus[$status])):
    [$msg, $corMsg] = $mapaStatus[$status];
    $isfront = $isFrontoffice ?? false;

    $layoutClass = $isfront ? 'start-50 m-5 translate-middle-x rounded-pill px-4' : 'm-4';
    $layoutStyle = $isfront ? 'z-index: 1050;' : 'min-width: 500px;';
    $icone = $isfront ? 'fa-bell fs-5' : 'fa-circle-info';
?>
    <div id="alerta" class="alert <?= $corMsg ?> alert-dismissible fade show shadow-lg position-fixed <?= $layoutClass ?>"style="<?= $layoutStyle ?>">
        <i class="fa-solid <?= $icone ?> me-2"></i>
        <span class="fw-bold pe-3"><?= $msg ?></span>
    </div>
    <script src="/Grupo6/site/assets/js/alerts.js" defer></script>
<?php endif;
