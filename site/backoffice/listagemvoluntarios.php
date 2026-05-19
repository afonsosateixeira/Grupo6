<?php
    if(!$rerun):
        $metaTitle = 'Listagem Voluntários';
        $metaDescription = 'Listar Voluntários';
    else:
        $sql = "SELECT * FROM vw_volunteer_full_schedule";
        $lista = $conn->query($sql);
?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telemóvel</th>
                    <th scope="col">Localidade</th>
                    <th scope="col">Horário</th>
                </tr>
            </thead>
            <tbody>
                <?php while($voluntario = $lista->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($voluntario['shift_id']) ?></td>
                        <td><?= htmlspecialchars($voluntario['volunteer_name']) ?></td>
                        <td><?= htmlspecialchars($voluntario['phone']) ?></td>
                        <td><?= htmlspecialchars($voluntario['city']) ?></td>
                        <td>
                            <?= htmlspecialchars($voluntario['day_week']) ?> – 
                            <?= date('H:i', strtotime($voluntario['start_time'])) ?> até 
                            <?= date('H:i', strtotime($voluntario['end_time'])) ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
<?php
    endif;
?>