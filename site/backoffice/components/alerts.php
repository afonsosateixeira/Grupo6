<?php if(isset($_GET['status'])): ?>

    <?php

        $status= $_GET['status'];
        $msg= '';
        $corMsg= 'alert-success';
        
        if($status == 'criado') $msg= 'Registo criado com sucesso';
        if($status == 'editado') $msg= 'Registo alterado com sucesso';
        if($status == 'status_alterado') $msg= 'Estado atualizado com sucesso!';
        if($status == 'apagado') {
            $msg= 'Registo eliminado com sucesso';
            $corMsg= 'alert-danger';
        }
        if($status == 'erro_validacao') {
            $msg = 'Dados inválidos no formulário. Preencha todos os campos corretamente.';
            $corMsg = 'alert-danger';
        }
        if($status == 'erro_imagem') {
            $msg = 'Erro ao carregar a imagem. Verifique o formato e o tamanho.';
            $corMsg = 'alert-warning';
        }

?>
        
    <?php if ($msg !== ''): ?>
        <div id="meuAlertaFlutuante" class="alert <?= $corMsg ?> alert-dismissible fade show shadow-lg position-fixed m-4" style="min-width: 500px;">
            <i class="fa-solid fa-circle-info me-2"></i> <?= $msg ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var alerta = document.getElementById("meuAlertaFlutuante");
                if (alerta) {
                    setTimeout(function() {
                        var bsAlert = new bootstrap.Alert(alerta);
                        bsAlert.close();
                    }, 3500);
                }
            });
        </script>
    <?php endif; ?>
<?php endif; ?>
