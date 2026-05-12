<?php
    $sql = "SELECT adoption_processes.*, adopters.full_name, animals.name
        FROM adoption_processes
        INNER JOIN adopters ON adoption_processes.adopter_id = adopters.id
        INNER JOIN animals ON adoption_processes.animal_id = animals.id
        ORDER BY adoption_processes.id ASC";
    $lista = $conn->query($sql);
?>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Adotante</th>
            <th>Animal</th>
            <th>Status</th>
            <th>Data</th>
            <th>Notas</th>
        </tr>
    </thead>
    <tbody>
        <?php while($linha=$lista->fetch_assoc()):?>
            <tr>
                <td><?= $linha['id'];?></td>
                <td><?= $linha['full_name'];?></td>
                <td><?= $linha['name'];?></td>
                <td><?= $linha['status'];?></td>
                <td><?= $linha['start_date'];?></td>
                <td><?= $linha['notes'];?></td>
            </tr>
        <?php endwhile;?>
    </tbody>
</table>