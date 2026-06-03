<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$modulo_url = strtok($_SERVER["REQUEST_URI"], '&?');
$query_string = array();
parse_str($_SERVER['QUERY_STRING'] ?? '', $query_string);
unset($query_string['delete']); 
$url_retorno = $modulo_url . (!empty($query_string) ? '?' . http_build_query($query_string) : '');

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    $sql = "DELETE FROM donations WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    header("Location: " . $url_retorno); 
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    $id = !empty($_POST['id']) ? intval($_POST['id']) : null;
    $amount = floatval($_POST['amount']);
    $payment_method = $_POST['payment_method'];

    if ($id) {
        $sql = "UPDATE donations SET amount = ?, payment_method = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "dsi", $amount, $payment_method, $id); // Alterado para "d" se amount for decimal/float
    } else {
        $sql = "INSERT INTO donations (amount, payment_method, donation_date) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ds", $amount, $payment_method);
    }
    
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    header("Location: " . $url_retorno);
    exit;
}

if (!$rerun) {
    $metaTitle = 'Lista de Doações';
    $metaDescription = 'Lista de Doações da Poppy and Max';
} else {
    $sql = "SELECT * FROM donations ORDER BY donation_date DESC";
    $result = mysqli_query($conn, $sql);
?>
    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Doações</h1>

        <div class="card mb-4 p-3 bg-light">
            <h5 class="fw-bold mb-3" id="form-title">Nova Doação</h5>
            <form action="" method="POST" class="row g-2 align-items-end">
                <input type="hidden" name="id" id="form-id" value="">
                
                <div class="col-md-4">
                    <label class="form-label small mb-1">Valor (€)</label>
                    <input type="number" step="0.01" class="form-control" name="amount" id="form-amount" required>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label small mb-1">Método de Pagamento</label>
                    <select class="form-select" name="payment_method" id="form-method" required>
                        <option value="Transferência Bancária">Transferência Bancária</option>
                        <option value="MB Way">MB Way</option>
                        <option value="Dinheiro">Dinheiro</option>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <button type="submit" name="salvar" class="btn btn-success w-100">Guardar</button>
                    <button type="button" id="btn-cancelar" class="btn btn-sm btn-link d-none w-100 text-center mt-1 text-secondary" onclick="resetForm()">Cancelar Edição</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover" id="donationTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Método de Pagamento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($donation = mysqli_fetch_assoc($result)) {
                            $query_string['delete'] = $donation['id'];
                            $link_eliminar = $modulo_url . '?' . http_build_query($query_string);
                            unset($query_string['delete']);
                    ?>
                            <tr>
                                <td class="text-secondary"><?php echo $donation['id']; ?></td>
                                <td class="fw-bold text-success"><?php echo $donation['amount']; ?> €</td>
                                <td><?php echo date('d/m/Y H:i', strtotime($donation['donation_date'])); ?></td>
                                <td class="text-dark fw-bold"><?php echo htmlspecialchars($donation['payment_method']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-link p-0 me-2" onclick="preencherFormulario(<?php echo $donation['id']; ?>, <?php echo $donation['amount']; ?>, '<?php echo addslashes($donation['payment_method']); ?>')">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    
                                    <a href="<?php echo $link_eliminar; ?>" onclick="return confirm('Eliminar esta doação?');"><i style="color: red;" class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                    <?php 
                        }
                    } else { 
                    ?>
                        <tr><td colspan="5" class="text-center text-muted">Nenhuma doação encontrada.</td></tr>
                    <?php 
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <script>
    function preencherFormulario(id, amount, method) {
        document.getElementById('form-id').value = id;
        document.getElementById('form-amount').value = amount;
        document.getElementById('form-method').value = method;
        
        document.getElementById('form-title').innerText = 'Editar Doação #' + id;
        document.getElementById('btn-cancelar').classList.remove('d-none');
        
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function resetForm() {
        document.getElementById('form-id').value = '';
        document.getElementById('form-amount').value = '';
        document.getElementById('form-method').value = 'Transferência Bancária';
        
        document.getElementById('form-title').innerText = 'Nova Doação';
        document.getElementById('btn-cancelar').classList.add('d-none');
    }
    </script>
<?php
}
?>