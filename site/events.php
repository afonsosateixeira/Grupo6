<?php
    if(!$rerun):
        $metaTitle = 'Eventos Passados';
        $metaDescription = 'Eventos passados da Poppy and Max';
    else:
        $stmt = $conn->prepare("SELECT id, name, event_date, end_date, location, description, event_type, status, capacity FROM events WHERE event_date < CURDATE() ORDER BY event_date DESC");
        $stmt->execute();
        $events = $stmt->get_result();
        $eventItems = $events->fetch_all(MYSQLI_ASSOC);

        $monthLabels = [
            '01' => 'JAN',
            '02' => 'FEV',
            '03' => 'MAR',
            '04' => 'ABR',
            '05' => 'MAI',
            '06' => 'JUN',
            '07' => 'JUL',
            '08' => 'AGO',
            '09' => 'SET',
            '10' => 'OUT',
            '11' => 'NOV',
            '12' => 'DEZ',
        ];

        $eventCoverImage = function (?string $name, ?string $type): string {
            $haystack = strtolower(trim(($type ?? '') . ' ' . ($name ?? '')));

            if (str_contains($haystack, 'cãominhada') || str_contains($haystack, 'caominhada') || str_contains($haystack, 'caminhada')) {
                return 'assets/img/home_yara.jpg';
            }

            if (str_contains($haystack, 'adoção') || str_contains($haystack, 'adocao') || str_contains($haystack, 'feira')) {
                return 'assets/img/home_zeus.webp';
            }

            if (str_contains($haystack, 'volunt') || str_contains($haystack, 'palestra')) {
                return 'assets/img/dia_voluntario_banner1.png';
            }

            if (str_contains($haystack, 'treino') || str_contains($haystack, 'workshop')) {
                return 'assets/img/home_mike.avif';
            }

            if (str_contains($haystack, 'campanha') || str_contains($haystack, 'fundos')) {
                return 'assets/img/home_lost_animals.png';
            }

            return 'assets/img/poppy_max.png';
        };
?>
        <section class="events-page">
            <div class="container events-header">
                <div class="events-header__copy">
                    <h1>EVENTOS PASSADOS</h1>
                </div>

                <button class="events-button events-button--desktop" type="button" data-bs-toggle="collapse" data-bs-target="#events-complete" aria-expanded="false" aria-controls="events-complete">TODOS OS EVENTOS PASSADOS</button>
                <button class="events-button events-button--mobile" type="button" data-bs-toggle="collapse" data-bs-target="#events-complete" aria-expanded="false" aria-controls="events-complete" aria-label="Ver todos os eventos passados">
                    <i class="fa-regular fa-calendar-days"></i>
                </button>
            </div>

            <div class="events-band">
                <div class="container-xl">
                    <?php if(empty($eventItems)): ?>
                        <div class="events-empty">
                            <h2>Sem eventos disponíveis</h2>
                            <p>Regressa mais tarde para ver as próximas atividades da comunidade.</p>
                        </div>
                    <?php else: ?>
                        <div class="events-grid" id="events-list">
                            <?php foreach(array_slice($eventItems, 0, 3) as $event): ?>
                                <?php
                                    $startTimestamp = strtotime($event['event_date']);
                                    $month = $monthLabels[date('m', $startTimestamp)] ?? strtoupper(date('M', $startTimestamp));
                                    $day = date('d', $startTimestamp);
                                    $coverImage = $eventCoverImage($event['name'], $event['event_type']);
                                ?>
                                <article class="event-card" style="--event-image: url('<?= $basePath ?>/<?= $coverImage ?>');">
                                    <div class="event-card__overlay"></div>
                                    <div class="event-card__content">
                                        <h2><?= htmlspecialchars($event['name']); ?></h2>
                                        <div class="event-card__meta">
                                            <span>
                                                <i class="fa-regular fa-clock"></i>
                                                <?= $day . ' ' . $month; ?>
                                            </span>
                                            <span>
                                                <i class="fa-solid fa-location-dot"></i>
                                                <?= htmlspecialchars($event['location']); ?>
                                            </span>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(!empty($eventItems)): ?>
                <div class="container events-complete collapse" id="events-complete">
                    <div class="events-complete__heading">
                        <h2>Lista completa de eventos</h2>
                        <p>Visão detalhada com data, hora, local, tipo, lotação e estado de cada evento.</p>
                    </div>

                    <div class="events-complete__list">
                        <?php foreach($eventItems as $event): ?>
                            <?php
                                $startTimestamp = strtotime($event['event_date']);
                                $endTimestamp = !empty($event['end_date']) ? strtotime($event['end_date']) : null;
                                $startTime = date('H:i', $startTimestamp);
                                $endTime = $endTimestamp ? date('H:i', $endTimestamp) : null;
                                $dateLabel = date('d/m/Y', $startTimestamp);
                                $statusLabel = $event['status'] === 'scheduled'
                                    ? 'Agendado'
                                    : ($event['status'] === 'completed'
                                        ? 'Concluído'
                                        : ($event['status'] === 'cancelled' ? 'Cancelado' : 'Adiado'));
                                $statusClass = $event['status'] === 'scheduled'
                                    ? 'is-scheduled'
                                    : ($event['status'] === 'completed'
                                        ? 'is-completed'
                                        : ($event['status'] === 'cancelled' ? 'is-cancelled' : 'is-postponed'));
                            ?>
                            <article class="events-complete__item <?= $statusClass; ?>">
                                <div class="events-complete__date">
                                    <span class="events-complete__day"><?= date('d', $startTimestamp); ?></span>
                                    <span class="events-complete__month"><?= $monthLabels[date('m', $startTimestamp)] ?? strtoupper(date('M', $startTimestamp)); ?></span>
                                    <span class="events-complete__year"><?= date('Y', $startTimestamp); ?></span>
                                </div>

                                <div class="events-complete__body">
                                    <div class="events-complete__top">
                                        <h3><?= htmlspecialchars($event['name']); ?></h3>
                                        <span class="events-complete__status"><?= $statusLabel; ?></span>
                                    </div>

                                    <p><?= !empty($event['description']) ? htmlspecialchars($event['description']) : 'Sem descrição disponível.'; ?></p>

                                    <div class="events-complete__meta">
                                        <span><i class="fa-regular fa-calendar"></i><?= $dateLabel; ?></span>
                                        <span><i class="fa-regular fa-clock"></i><?= $startTime; ?><?php if($endTime): ?> - <?= $endTime; ?><?php endif; ?></span>
                                        <span><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($event['location']); ?></span>
                                        <span><i class="fa-solid fa-tag"></i><?= htmlspecialchars($event['event_type']); ?></span>
                                        <?php if(!empty($event['capacity'])): ?>
                                            <span><i class="fa-solid fa-people-group"></i><?= (int)$event['capacity']; ?> lugares</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </section>
<?php
        $events->free();
        $stmt->close();
    endif;
