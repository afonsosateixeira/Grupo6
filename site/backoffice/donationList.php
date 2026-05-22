<?php
    if(!$rerun):
        $metaTitle = 'Lista de Doações';
        $metaDescription = 'Lista de Doações da Poppy and Max';
    else:

        $sql = "SELECT * FROM donations ORDER BY donation_date DESC";
        $result = $conn->query($sql);
?>
    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Doações</h1>
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
                                <td>
                                    <a href=""><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href=""><i style="color: #dc3545;" class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
<?php
    endif;
?>