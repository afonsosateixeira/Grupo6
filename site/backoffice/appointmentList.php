<?php
	if(!$rerun):
		$metaTitle = 'Gestão de consultas';
		$metaDescription = 'Gestão de consultas';

    else:
    $dados= "select a.id, a.animal, a.name_animal, a.age_animal, a.breed_animal, a.vet_id, v.name AS vet_name, a.appointment_date, a.status 
                from appointments a
                left join veterinarians v on a.vet_id = v.id
                order by id";
    $conection = $conn->query($dados);

        $appointmentEdit = null;
        if (isset($_GET['editar'])) {
            $id = (int) $_GET['editar'];
            $stmt = $conn->prepare("SELECT a.id, a.animal, a.name_animal, a.age_animal, a.breed_animal, a.vet_id, v.name AS vet_name, a.appointment_date, a.status 
                from appointments a
                left join veterinarians v on a.vet_id = v.id WHERE a.id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $appointmentEdit = $stmt->get_result()->fetch_assoc();
        }
?>
    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Consultas</h1>
        <div>
            <a href="appointmentList?add" class="btn btn-success">+ Criar</a>
        </div>
        <?php include 'components/modal_appointments.php'; ?>
        <table class="table table-striped table-hover" id="appointmentsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Nome do animal</th>
                    <th>Idade do animal</th>
                    <th>Raça do animal</th>
                    <th>Veterinário</th>
                    <th>Data da consulta</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach($conection as $variaveis): ?>
                <tr>
                    <th scope="row"><?= $variaveis['id'] ?></th>
                     <td><?= htmlspecialchars($variaveis['animal']) ?></td>
                    <td><?= htmlspecialchars($variaveis['name_animal']) ?></td>
                    <td><?= htmlspecialchars($variaveis['age_animal']) ?></td>
                    <td><?= htmlspecialchars($variaveis['breed_animal']) ?></td>
                     <td><?= (!empty($variaveis['vet_name'])) ? htmlspecialchars($variaveis['vet_name']) : 'Não tem veterinário' ?></td>
                    <td><?= htmlspecialchars($variaveis['appointment_date']) ?></td>
                    <td><?= htmlspecialchars($variaveis['status']) ?></td>
                    <td>
                        <a href="?editar=<?= $variaveis['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="components/action_appointment.php?action=eliminar&id=<?= $variaveis['id']; ?>" onclick="return confirm('Tem certeza que deseja eliminar esta consulta?')">
                            <i style="color: #dc3545;" class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <script>
            window.onload = function () {
                <?php if ($appointmentEdit || isset($_GET['add'])): ?>
                    var meuModal = new bootstrap.Modal(document.getElementById('formModalappointment'));
                    meuModal.show();
                <?php endif; ?>
            };
        </script>
    </section>
<?php
	endif;