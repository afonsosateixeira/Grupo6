<?php
	if(!$rerun):
		$metaTitle = 'Gestão de consultas';
		$metaDescription = 'Gestão de consultas';

    else:
    $dados= "select a.animal_id, v.name AS vet_name, a.reason, a.appointment_date, a.status 
                from appointments a
                join veterinarians v on a.vet_id = v.id
                order by a.animal_id";
    $conection = $conn->query($dados);
        
?>       
    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Consultas</h1>
        <table class="table table-striped table-hover" id="appointmentsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Veterinário</th>
                    <th>Tipo de consulta</th>
                    <th>Data da consulta</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach($conection as $variaveis): ?>
                <tr>
                    <th scope="row"><?= $variaveis['animal_id'] ?></th>
                    <td><?= htmlspecialchars($variaveis['vet_name']) ?></td>
                    <td><?= htmlspecialchars($variaveis['reason']) ?></td>
                    <td><?= htmlspecialchars($variaveis['appointment_date']) ?></td>
                    <td><?= htmlspecialchars($variaveis['status']) ?></td>
                    <td>
                        <a href=""><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href=""><i style="color: #dc3545;" class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
<?php
	endif;