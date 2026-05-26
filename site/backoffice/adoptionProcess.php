<?php
if (!$rerun):
    $metaTitle = ''; $metaDescription = '';
else:
    $sql = "SELECT ap.*, u.full_name, a.image, a.name, a.birth_date, s.name AS specie 
            FROM adoption_processes ap 
            INNER JOIN users u ON ap.user_id = u.id 
            INNER JOIN animals a ON ap.animal_id = a.id 
            INNER JOIN species s on a.specie_id = s.id 
            ORDER BY ap.id ASC";
    $group = $conn->query($sql);

    // Lógica de edição
    $adoptEdit = null;
    if ($id = (int)($_GET['editar'] ?? 0)) {
        $sql = "SELECT ap.*, u.full_name, a.image, a.name, a.birth_date, s.name AS specie FROM adoption_processes ap INNER JOIN users u ON ap.user_id = u.id INNER JOIN animals a ON ap.animal_id = a.id INNER JOIN species s on a.specie_id = s.id WHERE ap.id=?";
        $adoptEdit = prepareQuery($conn, $sql, 'i', $id)->get_result()->fetch_assoc();
    }

    $processos = ['Pendente' => [], 'Aprovado' => [], 'Rejeitado' => []];
    foreach ($group as $linha) $processos[$linha['status']][] = $linha; 

    function desenharcards($title, $array, $cor) { ?>
        <div class="col-12 col-md-4">
            <div class="<?= $cor ?> text-center p-2 mb-3 rounded shadow-sm">
                <h3 class="text-white m-0"><?= $title ?></h3>
            </div>

            <?php if (empty($array)): ?>
                <p class="text-center text-muted mt-3">Sem processos.</p>
            <?php else: foreach ($array as $item): 
                $img = !empty($item['image']) ? "../assets/img/animals/{$item['image']}" : "assets/img/defaultAnimals.png";
            ?>
                <div class="card mb-3 shadow-sm border-0" style="border-radius: 10px;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                            <img class="rounded-circle me-3" style="width: 55px; height: 55px; object-fit: cover;" src="<?= $img ?>" alt="Foto de <?= htmlspecialchars($item['name']) ?>">
                            <div>
                                <h5 class="mb-0 fw-bold"><?= htmlspecialchars($item['name']) ?></h5>
                                <small class="text-muted"><?= mostrarIdade($item['birth_date'], false) ?> | <?= htmlspecialchars($item['specie']) ?></small>
                            </div>
                        </div>

                        <div>
                            <p class="mb-1 fw-bold"><i class="fa-solid fa-user me-2 text-secondary"></i><?= htmlspecialchars($item['full_name']) ?></p>
                            <p class="mb-1 small"><i class="fa-solid fa-calendar-day me-2 text-secondary"></i><?= date('d/m/Y', strtotime($item['start_date'])) ?></p>
                            <?php if (!empty($item['notes'])): ?>
                                <p class="mb-1 small text-muted fst-italic"><i class="fa-solid fa-comment me-2"></i><?= htmlspecialchars($item['notes']) ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-3">
                            <?php if ($title === "Pendente"): ?>
                                <a href="components/action_adoption.php?action=mudar_status&id=<?= $item['id'] ?>&status=Aprovado" title="Aprovar"><i class="fa-solid fa-check text-success fs-5"></i></a>
                                <a href="components/action_adoption.php?action=mudar_status&id=<?= $item['id'] ?>&status=Rejeitado" title="Rejeitar"><i class="fa-solid fa-xmark text-danger fs-5"></i></a>
                                <a href="?editar=<?= $item['id'] ?>" title="Editar"><i class="fa-solid fa-pen-to-square text-primary fs-5"></i></a>
                                <a onclick="return confirm('Deseja eliminar este processo?');" href="components/action_adoption.php?action=eliminar&id=<?= $item['id'] ?>" title="Eliminar"><i class="fa-solid fa-trash text-danger fs-5"></i></a>
                            <?php else: ?>
                                <a href="components/action_adoption.php?action=mudar_status&id=<?= $item['id'] ?>&status=Pendente" title="Voltar a Pendente"><i class="fa-solid fa-rotate-left text-secondary fs-5"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    <?php } ?>

    <section class="container-fluid ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Processos de Adoção</h1>
        <div class="d-flex justify-content-end gap-2 mb-3">
            <a href="?add" class="btn btn-success">+ Criar</a>
        </div>
        
        <?php include 'components/modal_adoption.php'; ?>
        
        <div class="row">
            <?php
            desenharcards("Pendente", $processos['Pendente'], "bg-warning");
            desenharcards("Aprovado", $processos['Aprovado'], "bg-success");
            desenharcards("Rejeitado", $processos['Rejeitado'], "bg-danger");
            ?>
        </div>
    </section>
<?php endif; ?>