<?php
	if(!$rerun):
		$metaTitle = 'Gestão de veterinários';
		$metaDescription = 'Gestão de veterinários';

  
    else:
    $dados = "select id, name, photo, license_number, specialty, phone from veterinarians 
                order by id";
    
    $conection = $conn->query($dados);        
?>       
    <section>
        <table class="table table-striped mt-3" id="vetsTable">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Especialidade</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach($conection as $item): ?>
                <tr>
                    <th scope="row"><?= htmlspecialchars($item['id']) ?></th>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>
                        <?php 
                            $caminhoImagem = !empty($item['photo']) ? "../assets/img/vet/" . $item['photo'] : "../assets/img/defaultVet.png"; 
                        ?>
                    <img class="rounded-circle vet-image img-thumbnail round-image text-muted" src="<?= $caminhoImagem ?>" style="border: 3px solid" alt="Foto do veterinário">
                    </td>
                    <td><?= htmlspecialchars($item['specialty']) ?></td>
                    <td><?= htmlspecialchars($item['phone']) ?></td>
                    <td>
                        <button class="btn btn-primary">Editar</button>
                        <button class="btn btn-danger">Excluir</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
<?php
	endif;