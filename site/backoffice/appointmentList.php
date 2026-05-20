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
    <section>
        <div class="container">
            
            <table class="table table-striped mt-3" id="appointmentsTable">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Veterinário</th>
                        <th scope="col">Tipo de consulta</th>
                        <th scope="col">Data da consulta</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ações</th>
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
                            <button class="btn btn-primary">Editar</button>
                            <button class="btn btn-danger">Excluir</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
<?php
	endif;