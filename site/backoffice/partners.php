<?php
if (!$rerun) {
    $metaTitle = 'Lista de Parceiros';
    $metaDescription = 'Lista de Parceiros da Poppy and Max';

    if (!empty($_GET['delete']) && !empty($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $conn->prepare("DELETE FROM partners WHERE id = ? ");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $stmt->close();
        $conn->close();

        header('Location: ./partners');
        exit();
    }

    $query = $conn->query("SELECT * FROM vw_corporate_partners_directory");

    $edit = null;
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $stmt = $conn->prepare("SELECT * FROM partners WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $edit = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }
} else {
?>
    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Parceiros</h1>

        <div class="d-flex justify-content-end gap-2 mb-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#formModal">
                <i class="fa-solid fa-plus me-1"></i> Adicionar Parceiro
            </button>
        </div>

        <?php
            require 'components/modal_partners.php';
        ?>

        <table class="table table-striped table-hover" id="partnersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Logótipo / Foto</th>
                    <th>Empresa</th>
                    <th>Pessoa de Contacto</th>
                    <th>Telemóvel</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($row = $query->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?= $row['id']?></td>
                            <td>
                                <img src="../assets/img/partners/<?= !empty($row['photo']) ? htmlspecialchars($row['photo']) : 'partner_default.svg' ?>" alt="Logótipo" style="width: 50px; height: auto;">
                            </td>
                            <td><?= htmlspecialchars($row['company_name'] ?? 'Sem nome') ?></td>
                            <td><?= htmlspecialchars($row['contact_person'] ?? 'Sem contacto') ?></td>
                            <td><?= htmlspecialchars($row['phone'] ?? 'Sem telefone') ?></td>
                            <td><?= htmlspecialchars($row['email'] ?? 'Sem email') ?></td>
                            <td>
                                <a href="?edit=<?= $row['id'] ?>"><i class="fa-solid fa-pen-to-square me-2"></i></a>
                                <a href="?id=<?= $row['id'] ?>&delete=true" onclick="return confirm('Tem a certeza que quer eliminar este parceiro?')"><i style="color: #dc3545;" class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (isset($_GET['edit']) && !empty($edit)): ?>
                var meuModal = new bootstrap.Modal(document.getElementById('formModal'));
                meuModal.show();
            <?php endif; ?>
        });
    </script>
    
<?php
}
?>