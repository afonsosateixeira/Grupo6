<?php
	if(!$rerun):
		$metaTitle = 'Gestão de histórico médico';
		$metaDescription = 'Gestão de histórico médico';  
    else:
    $dados = "select id, diagnosis, weight from medical_history 
                order by id";
    
    $conection = $conn->query($dados);     
    
    $historyEdit = null;
        if (isset($_GET['editar'])) {
            $id = (int) $_GET['editar'];
            $stmt = $conn->prepare("SELECT id, diagnosis, weight from medical_history WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $historyEdit = $stmt->get_result()->fetch_assoc();
        }
?>       
    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Histórico Médico</h1>
        <div class="d-flex justify-content-end">
            <a href="medicalHistory?add" class="btn btn-success">+ Criar</a>
        </div>
        <?php include 'components/modal_medicalHistory.php'; ?>
        <table class="table table-striped table-hover" id="medicalHistoryTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Diagnóstico</th>
                    <th>Peso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach($conection as $item): ?>
                <tr>
                    <th scope="row"><?= htmlspecialchars($item['id']) ?></th>
                    <td><?= htmlspecialchars($item['diagnosis']) ?></td>
                    <td><?= htmlspecialchars($item['weight']) ?></td>
                    <td>
                        <a href="?editar=<?= $item['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="components/action_medicalHistory.php?action=eliminar&id=<?= $item['id']; ?>" onclick="return confirm('Tem certeza que deseja eliminar este histórico médico?')">
                            <i style="color: #dc3545;" class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <script>
            window.onload = function () {
                <?php if ($historyEdit || isset($_GET['add'])): ?>
                    var meuModal = new bootstrap.Modal(document.getElementById('formModalHistory'));
                    meuModal.show();
                <?php endif; ?>
            };
        </script>
    </section>
<?php
	endif;