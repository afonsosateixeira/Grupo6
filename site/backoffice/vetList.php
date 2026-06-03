<?php
	if(!$rerun):
		$metaTitle = 'Gestão de veterinários';
		$metaDescription = 'Gestão de veterinários';

  
    else:
    $dados = "select id, name, photo, phone from veterinarians 
                order by id";
    
    $conection = $conn->query($dados);     
    
    $vetEdit = null;
        if (isset($_GET['editar'])) {
            $id = (int) $_GET['editar'];
            $stmt = $conn->prepare("SELECT id, name, photo , phone FROM veterinarians WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $vetEdit = $stmt->get_result()->fetch_assoc();
        }
?>       
    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Veterinários</h1>
        <div class="d-flex justify-content-end">
            <a href="vetList?add" class="btn btn-success">+ Criar</a>
        </div>
        <?php include 'components/modal_vet.php'; ?>
        <table class="table table-striped table-hover" id="vetsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Foto</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach($conection as $item): ?>
                <tr>
                    <th scope="row"><?= htmlspecialchars($item['id']) ?></th>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>
                        <?php 
                            $caminhoImagem = !empty($item['photo']) ? "../assets/img/vet/" . $item['photo'] : "../assets/img/vet/defaultVet.jpg"; 
                        ?>
                    <img class="rounded-circle vet-image img-thumbnail round-image text-muted" src="<?= $caminhoImagem ?>" style="border: 3px solid" alt="Foto do veterinário">
                    </td>
                    <td><?= htmlspecialchars($item['phone']) ?></td>
                    <td>
                        <a href="?editar=<?= $item['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="components/action_vet.php?action=eliminar&id=<?= $item['id']; ?>" onclick="return confirm('Tem certeza que deseja eliminar este veterinário?')">
                            <i style="color: #dc3545;" class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <script>
            window.onload = function () {
                <?php if ($vetEdit || isset($_GET['add'])): ?>
                    var meuModal = new bootstrap.Modal(document.getElementById('formModalvet'));
                    meuModal.show();
                <?php endif; ?>
            };
        </script>
    </section>
<?php
	endif;