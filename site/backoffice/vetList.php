<?php
	if(!$rerun):
		$metaTitle = 'Gestão de veterinários';
		$metaDescription = 'Gestão de veterinários';

  
    else:
    $dados = "select id, name, photo, license_number, specialty, phone from veterinarians 
                order by id";
    
    $conection = $conn->query($dados);        
?>       
    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Veterinários</h1>
        <table class="table table-striped table-hover" id="vetsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Foto</th>
                    <th>Especialidade</th>
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
                            $caminhoImagem = !empty($item['photo']) ? "../assets/img/vet/" . $item['photo'] : "../assets/img/defaultVet.png"; 
                        ?>
                    <img class="rounded-circle vet-image img-thumbnail round-image text-muted" src="<?= $caminhoImagem ?>" style="border: 3px solid" alt="Foto do veterinário">
                    </td>
                    <td><?= htmlspecialchars($item['specialty']) ?></td>
                    <td><?= htmlspecialchars($item['phone']) ?></td>
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