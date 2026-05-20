<?php
if (!$rerun):
    $metaTitle = '';
    $metaDescription = '';
else:
    $sql = "SELECT ap.*, u.full_name, a.image, a.name, a.birth_date, s.name AS specie
            FROM adoption_processes ap
            INNER JOIN users u ON ap.user_id = u.id
            INNER JOIN animals a ON ap.animal_id = a.id
            INNER JOIN species s on a.specie_id = s.id
            ORDER BY ap.id ASC";
    $lista = $conn->query($sql);

    $adoptEdit=null;
    if(isset($_GET['editar'])){
        $id= (int)$_GET['editar'];
        $stmt= $conn->prepare("SELECT * FROM adoption_processes WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $adoptEdit= $stmt->get_result()->fetch_assoc();
    }

    $pendente = [];
    $aprovado = [];
    $rejeitado = [];

    foreach ($lista as $linha) {
        if ($linha['status'] === "Pendente") {
            $pendente[] = $linha;
        }
        if ($linha['status'] === "Aprovado") {
            $aprovado[] = $linha;
        }
        if ($linha['status'] === "Rejeitado") {
            $rejeitado[] = $linha;
        }
    }
    function desenharcards($title, $array, $cor)
    {
        ?>
        <div class="col-12 col-md-4">
            <div class="<?= $cor ?> text-center p-2 mb-3 rounded">
                <h3 class="text-white m-0"><?= $title ?></h3>
            </div>

            <?php foreach ($array as $item): ?>
                <div class="card mb-3 shadow-sm border-0" style="border-radius: 10px;">
                    <div class="card-body p-3">

                        <div class="d-flex align-items-center mb-3">
                            <?php
                            $caminhoImagem = !empty($item['image']) ? "../assets/img/animals/" . $item['image'] : "assets/img/defaultAnimals.png";
                            ?>
                            <img class="rounded-circle me-3" style="width: 55px; height: 55px; object-fit: cover;"
                                src="<?= $caminhoImagem ?>" alt="Foto de <?= htmlspecialchars($item['name']) ?>">

                            <div>
                                <h5 class="mb-0 fw-bold"><?= htmlspecialchars($item['name']) ?></h5>
                                <p class="text-muted"> <?= mostrarIdade($item['birth_date'], false)?> | <?= htmlspecialchars($item['specie']) ?></p>
                            </div>
                        </div>

                        <div>
                            <h5 class="mb-1 fw-bold"><?= htmlspecialchars($item['full_name']) ?></h5>
                            <p class="mb-1"><?= htmlspecialchars($item['start_date']) ?></p>
                            <p class="mb-1"><?= htmlspecialchars($item['notes']) ?></p>
                        </div>

                        <div class="text-end mt-2">
                            <?php if ($title === "Pendente"): ?>
                                <a href="components/action_adoption.php?action=mudar_status&id=<?= $item['id']?>&status=Aprovado"><i style="color: #198754;" class="fa-solid fa-check"></i></a>

                                <a href="components/action_adoption.php?action=mudar_status&id=<?= $item['id']?>&status=Rejeitado"><i style="color: #dc3545;" class="fa-solid fa-xmark"></i></a>

                                <a href="components/action_adoption.php?editar=<?= $item['id']?>"><i class="fa-solid fa-pen-to-square"></i></a>

                                <a onclick="return confirm('Tem certeza que deseja eliminar este processo?');" href="components/action_adoption.php?action=eliminar&id=<?= $item['id']?>"><i style="color: #dc3545;" class="fa-solid fa-trash"></i></a>

                            <?php else: ?>
                                <a href="components/action_adoption.php?action=mudar_status&id=<?= $item['id']?>&status=Pendente"><i style="color: #6c757d;" class="fa-solid fa-rotate-left"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($array)): ?>
                <p class="text-center text-muted mt-3">Sem processos.</p>
            <?php endif; ?>

        </div>
        <?php
    }
    ?>
    <div class="container">
        <h1 class="fw-bold fs-2">Lista de Adoções</h1>
        <div class="d-flex justify-content-end gap-2 mb-3">
            <a href="adoptionProcess?add" class="btn btn-success">+ Criar</a>
        </div>
        <?php include 'components/modal_adoption.php'; ?>
        <div class="row">
            <?php
            desenharcards("Pendente", $pendente, "bg-warning");
            desenharcards("Aprovado", $aprovado, "bg-success");
            desenharcards("Rejeitado", $rejeitado, "bg-danger");
            ?>
        </div>
    </div>
    <script>
            window.onload = function () {
                <?php if ($adoptEdit || isset($_GET['add'])): ?>
                    var meuModal = new bootstrap.Modal(document.getElementById('formModal'));
                    meuModal.show();
                <?php endif; ?>
            };
        </script>
    <?php
endif;