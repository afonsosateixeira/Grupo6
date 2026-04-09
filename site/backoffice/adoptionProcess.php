<?php
require_once("../config.php");

$sql = "SELECT adoption_processes.*, adopters.full_name, animals.name
FROM adoption_processes
INNER JOIN adopters ON adoption_processes.adopter_id = adopters.id
INNER JOIN animals ON adoption_processes.animal_id = animals.id
 ORDER BY adoption_processes.id ASC";
$lista = $config->query($sql);

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <?php
        $metaTitle = "Processo de Adoção";
        $metaDescription = "";
        $backOffice = true;
        require_once "../components/head.php";
    ?>
</head>

<body>
    <?php require_once("../components/sidebar.html");?>

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
                    <td><?php echo $linha['id'];?></td>
                    <td><?php echo $linha['full_name'];?></td>
                    <td><?php echo $linha['name'];?></td>
                    <td><?php echo $linha['status'];?></td>
                    <td><?php echo $linha['start_date'];?></td>
                    <td><?php echo $linha['notes'];?></td>
                </tr>
            <?php endwhile;?>

        </tbody>
    </table>
</body>
</html>