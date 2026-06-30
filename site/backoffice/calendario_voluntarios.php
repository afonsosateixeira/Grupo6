<?php
if (!$rerun):
    $metaTitle = 'Calendarios de Voluntarios';
    $metaDescription = 'Calendarios de Voluntarios';
else:
    $sql = "SELECT shift_id, volunteer_name, day_week, start_time, end_time FROM vw_volunteer_full_schedule WHERE status = 'Aceite'";
    $result = $conn->query($sql);

    $editMode = false;
    $volunteerEdit = null;
    if (isset($_GET['editar']) && is_numeric($_GET['editar'])) {
        $editId = (int) $_GET['editar'];
        $sqlEdit = "SELECT * FROM vw_volunteer_full_schedule WHERE shift_id = $editId LIMIT 1";
        $resEdit = $conn->query($sqlEdit);
        if ($resEdit && $rowEdit = $resEdit->fetch_assoc()) {
            $editMode = true;
            $volunteerEdit = $rowEdit;
        }
    }

    $dayOrder = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado', 'Domingo'];
    $displayDay = [
        'Segunda-feira' => '2ª feira',
        'Terça-feira' => '3ª feira',
        'Quarta-feira' => '4ª feira',
        'Quinta-feira' => '5ª feira',
        'Sexta-feira' => '6ª feira',
        'Sábado' => 'Sábado',
        'Domingo' => 'Domingo'
    ];

    $scheduleByDay = array_fill_keys($dayOrder, []);

    while ($row = $result->fetch_assoc()) {
        $day = trim($row['day_week'] ?? '');
        if ($day === 'Segunda') {
            $day = 'Segunda-feira';
        } elseif ($day === 'Terça') {
            $day = 'Terça-feira';
        } elseif ($day === 'Quarta') {
            $day = 'Quarta-feira';
        } elseif ($day === 'Quinta') {
            $day = 'Quinta-feira';
        } elseif ($day === 'Sexta') {
            $day = 'Sexta-feira';
        }

        if (array_key_exists($day, $scheduleByDay)) {
            $scheduleByDay[$day][] = $row;
        }
    }

    foreach ($scheduleByDay as &$items) {
        usort($items, function ($a, $b) {
            return strcmp($a['start_time'], $b['start_time']);
        });
    }
    unset($items);
?>
    <section class="ms-2">
        <h1 class="fw-bold custom-blue mt-2 mb-4">Calendário de Voluntários</h1>

        <div class="row row-cols-7 g-3 m-0">
            <?php foreach ($scheduleByDay as $weekday => $turnos): ?>

                <div class="col d-flex flex-column gap-3">

                    <div class="cabecalho-dia p-2 text-center fw-bold border rounded-3">
                        <?= htmlspecialchars($displayDay[$weekday] ?? $weekday) ?>
                    </div>

                    <?php foreach ($turnos as $turno): ?>
                        <div class="cartao-turno p-3 text-light rounded-3">
                            <strong><?= htmlspecialchars($turno['volunteer_name']) ?></strong>
                            <div class="horario">Horário: <?= htmlspecialchars($displayDay[$weekday] ?? $weekday) ?> - <?= date('H:i', strtotime($turno['start_time'])) ?> até <?= date('H:i', strtotime($turno['end_time'])) ?></div>
                            <div class="mt-2 text-center">
                                <a href="?editar=<?= (int)($turno['shift_id'] ?? 0) ?>" class="text-white" title="Editar turno">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
    require __DIR__ . '/components/modal_calendario_voluntario.php';

    if (!empty($editMode)):
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('formModalCalendarioVoluntario'));
                myModal.show();
            });
        </script>
<?php
    endif;
endif;
?>