<?php
    if(!$rerun):
        $metaTitle = 'Lista de Doações';
        $metaDescription = 'Lista de Doações da Poppy and Max';
    else:

        $sql = "SELECT * FROM donations ORDER BY donation_date DESC";
        $result = $conn->query($sql);
        
        $conn->close();
?>
    <section class="container-fluid py-4">
        <div class="d-flex justify-content-between ">
            <h1>Histórico de Doações Recebidas</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped" id="donationTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Método de Pagamento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php foreach ($result as $donation): ?>
                            <tr>
                                <td class="text-secondary">
                                    <?= $donation['id'] ?>
                                </td>
                                <td class="fw-bold text-success">
                                    <?= $donation['amount'] ?> €
                                </td>
                                <td>
                                    <?= date('d/m/Y', strtotime($donation['donation_date'])) ?>
                                </td>
                                <td class="text-dark fw-bold"> <?= htmlspecialchars($donation['payment_method']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
<?php
    endif;
?>