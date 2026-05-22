<?php
    if(!$rerun):
        $metaTitle = 'Listagem Voluntários';
        $metaDescription = 'Listar Voluntários';
    else:
        $sql = "SELECT * FROM vw_volunteer_full_schedule";
        $lista = $conn->query($sql);
?>
    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Gestão de Voluntários</h1>
        <table class="table table-striped table-hover" id="volunteerTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telemóvel</th>
                    <th>Localidade</th>
                    <th>Horário</th>
                    <th>Ações</th>
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
                        <td>
                        <a href=""><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href=""><i style="color: #dc3545;" class="fa-solid fa-trash"></i></a>
                    </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>
<?php
    endif;
?>