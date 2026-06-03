<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donationMethod'])) {
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    $payment_method = filter_input(INPUT_POST, 'donationMethod', FILTER_DEFAULT); 
    $donation_date = date('Y-m-d H:i:s');

    if ($amount && $amount > 0 && $payment_method) {
        $stmt = $conn->prepare("INSERT INTO donations (amount, payment_method, donation_date) VALUES (?, ?, ?)");
        $stmt->bind_param("dss", $amount, $payment_method, $donation_date);
        
        if ($stmt->execute()) {
            // Guarda o feedback na sessão
            $_SESSION['submissao_status'] = 'success';
            $_SESSION['submissao_valor'] = $amount;
        } else {
            $_SESSION['submissao_status'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['submissao_status'] = 'invalid';
    }
    
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$status_submissao = $_SESSION['submissao_status'] ?? "";
$valor_doado = $_SESSION['submissao_valor'] ?? 0;
unset($_SESSION['submissao_status'], $_SESSION['submissao_valor']);

if(!$rerun):
    $metaTile = 'Painel de Doações';
    $metaDescription = 'Painel de Doações da Poppy and Max';
else:
    $sql = "SELECT * FROM donations ORDER BY amount DESC LIMIT 4";
    $result = $conn->query($sql);
    $conn->close();
?>

    <section class="container-fluid py-5">
        <div class="mx-auto text-center col-10 col-md-8">
            <h1 class="display-4 fw-bold fs-1">Ajuda-nos a dar uma segunda vida a animais abandonados</h1>
            <p class="lead">Cada doação garante cuidados, abrigo e uma nova oportunidade</p>
        </div>
    </section>

    <section class="background">
        <div class="container py-4">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-5">
                    
                    <form id="donationForm" method="POST" action="">
                        <div class="mb-3">
                            <label for="amount" class="form-label text-white">Valor da Doação</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" placeholder="0.00" required>
                        </div>

                        <div class="btn-group w-100 mb-4" data-toggle="buttons">
                            <input type="radio" class="btn-check" id="btn-check-mbway" name="donationMethod" value="MBway" autocomplete="off" required>
                            <label class="btn btn-custom-mbway" for="btn-check-mbway">MBWay</label>
                        
                            <input type="radio" class="btn-check" id="btn-check-trans" name="donationMethod" value="Transferência" autocomplete="off">
                            <label class="btn btn-custom-trans" for="btn-check-trans">Transferência</label>
                        </div>
                    
                        <div class="d-grid gap-2">
                            <button class="btn btn-custom-con" type="submit">Enviar Doação</button>
                        </div>
                    </form>

                </div>

                <div class="col-12 col-lg-7">
                    <div class="position-relative overflow-hidden rounded shadow text-white">
                        <img src="assets/img/donations_banner.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Doação Banner" style="min-height: 250px;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
                        <div class="position-absolute top-50 start-50 translate-middle text-center w-100 px-3">
                            <h3 class="fw-bold m-0 fs-4 text-uppercase tracking-wide">Mais de 5000€ já foram doados para dar novas casas aos nossos amigos patudos</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container my-4">
        <div class="row g-4">
            <h3 class="display-6 fw-bold text-center mb-4">Top Doações</h3>
                
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($donation = $result->fetch_assoc()): ?>
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-custom h-100 border-0">
                            <div class="card-body text-center">
                                <h4 class="card-title fw-bold text-dark display-6 mb-3">
                                    <?= number_format($donation['amount'], 2, ',', '.') ?>€
                                </h4>
                                <p class="card-text text-muted small mb-1">
                                    Método de doação: <?= htmlspecialchars($donation['payment_method'] ?? 'N/A') ?>
                                </p>
                                <p class="card-text text-muted extreme-small">
                                    <i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($donation['donation_date'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Ainda não existem doações registadas. Seja o primeiro!</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script>
        document.getElementById('donationForm').addEventListener('submit', function(e) {
            const valor = document.getElementById('amount').value;
            const metodoSelecionado = document.querySelector('input[name="donationMethod"]:checked');
            
            if (!metodoSelecionado) {
                alert('Por favor, selecione um método de doação.');
                e.preventDefault();
                return;
            }

            if (!confirm(`Confirmar doação de ${valor}€ via ${metodoSelecionado.value}?`)) {
                e.preventDefault();
            }
        });

        const statusSubmissao = "<?= $status_submissao ?>";
        const valorDoado = "<?= number_format($valor_doado, 2, ',', '.') ?>";

        if (statusSubmissao === 'success') {
            alert(`Sucesso! Obrigado pela doação de ${valorDoado}€.`);
        } else if (statusSubmissao === 'error') {
            alert('Erro ao guardar a doação.');
        } else if (statusSubmissao === 'invalid') {
            alert('Por favor, preencha os dados corretamente.');
        }
    </script>

<?php
    endif;
?>