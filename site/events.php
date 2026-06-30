<?php
    if(!$rerun):
        $metaTitle = 'Eventos Passados';
        $metaDescription = 'Eventos passados da Poppy and Max';
    else:
        require_once 'helpers/eventHelpers.php';
        
        $stmt = $conn->prepare("SELECT id, name, event_date, end_date, location, description, event_type, status, capacity FROM events WHERE event_date < CURDATE() ORDER BY event_date DESC");
        $stmt->execute();
        $eventItems = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
                                <?php $ts = strtotime($event['event_date']); ?>
                                <article class="event-card" style="--event-image: url('<?= $basePath ?>/<?= getEventCoverImage($event['name'], $event['event_type']) ?>');">
                                    <div class="event-card__overlay"></div>
                                    <div class="event-card__content">
                                        <h2><?= htmlspecialchars($event['name']); ?></h2>
                                        <div class="event-card__meta">
                                            <span>
                                                <i class="fa-regular fa-clock"></i>
                                                <?= date('d', $ts) . ' ' . (MONTH_SHORT[date('m', $ts)] ?? strtoupper(date('M', $ts))); ?>
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
                                $ts = strtotime($event['event_date']);
                                $endTs = !empty($event['end_date']) ? strtotime($event['end_date']) : null;
                                $statusLabel = getStatusLabel($event['status']);
                                $statusClass = getStatusClass($event['status']);
                            ?>
                            <article class="events-complete__item <?= $statusClass; ?>">
                                <div class="events-complete__date">
                                    <span class="events-complete__day"><?= date('d', $ts); ?></span>
                                    <span class="events-complete__month"><?= MONTH_SHORT[date('m', $ts)] ?? strtoupper(date('M', $ts)); ?></span>
                                    <span class="events-complete__year"><?= date('Y', $ts); ?></span>
                                </div>

                                <div class="events-complete__body">
                                    <div class="events-complete__top">
                                        <h3><?= htmlspecialchars($event['name']); ?></h3>
                                        <span class="events-complete__status"><?= $statusLabel; ?></span>
                                    </div>

                                    <p><?= !empty($event['description']) ? htmlspecialchars($event['description']) : 'Sem descrição disponível.'; ?></p>

                                    <div class="events-complete__meta">
                                        <span><i class="fa-regular fa-calendar"></i><?= date('d/m/Y', $ts); ?></span>
                                        <span><i class="fa-regular fa-clock"></i><?= date('H:i', $ts); ?><?php if($endTs): ?> - <?= date('H:i', $endTs); ?><?php endif; ?></span>
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
        $stmt->close();
    endif;
