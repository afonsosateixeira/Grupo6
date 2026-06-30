<?php
    if(!$rerun):
        $metaTitle = 'Calendário de Eventos';
        $metaDescription = 'Calendário com os próximos eventos e galeria da comunidade Poppy and Max';
    else:
        require_once 'helpers/eventHelpers.php';
        
        $stmtUpcoming = $conn->prepare("SELECT id, name, event_date, location, event_type FROM events WHERE event_date >= CURDATE() AND status != 'cancelled' ORDER BY event_date ASC");
        $stmtUpcoming->execute();
        $upcomingEvents = $stmtUpcoming->get_result()->fetch_all(MYSQLI_ASSOC);
        $upcomingTwo = array_slice($upcomingEvents, 0, 2);

        $eventDates = [];
        $allEventsByDate = [];
        foreach($upcomingEvents as $ev){
            $ts = strtotime($ev['event_date']);
            $isoDate = date('Y-m-d', $ts);
            $eventDates[] = $isoDate;
            $allEventsByDate[$isoDate][] = [
                'name' => $ev['name'],
                'date_label' => date('d', $ts).' '.(MONTH_SHORT[date('m', $ts)] ?? strtoupper(date('M', $ts))),
                'location' => $ev['location'],
                'image' => $basePath.'/'.getEventCoverImage($ev['name'], $ev['event_type']),
            ];
        }
        $eventDates = array_values(array_unique($eventDates));

        $renderEventCard = function (?array $event, string $sizeClass, string $fallbackTitle) use ($basePath) {
            if(!$event){
                $cover = $basePath.'/assets/img/poppy_max.png';
                $dateLabel = '-- ---';
                $locationLabel = 'Parque Canino Leiria';
                $titleLabel = $fallbackTitle;
            } else {
                $ts = strtotime($event['event_date']);
                $monthKey = date('m', $ts);
                $dateLabel = date('d', $ts).' '.(MONTH_SHORT[$monthKey] ?? strtoupper(date('M', $ts)));
                $locationLabel = $event['location'];
                $titleLabel = $event['name'];
                $cover = $basePath.'/'.getEventCoverImage($event['name'], $event['event_type']);
            }
?>
            <article class="cal-event-card <?= $sizeClass; ?>" style="--calendar-event-image: url('<?= $cover; ?>');">
                <div class="cal-event-card__overlay"></div>
                <div class="cal-event-card__content">
                    <h2><?= htmlspecialchars($titleLabel); ?></h2>
                    <div class="cal-event-card__meta">
                        <span><i class="fa-regular fa-clock"></i><?= htmlspecialchars($dateLabel); ?></span>
                        <span><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($locationLabel); ?></span>
                    </div>
                </div>
            </article>
<?php
        };
?>
        <section class="cal-page">
            <script>window._calEventsByDate=<?= json_encode($allEventsByDate, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?>;</script>
            <div class="container-xl cal-layout">
                <div class="cal-widget" data-calendar-root data-event-dates='<?= json_encode($eventDates, JSON_UNESCAPED_UNICODE); ?>'>
                    <div class="cal-widget__header">
                        <button type="button" class="cal-widget__nav" data-calendar-prev aria-label="Mês anterior">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <h1 data-calendar-month><?= MONTH_FULL[(int)date('n')] ?? date('F'); ?></h1>
                        <button type="button" class="cal-widget__nav" data-calendar-next aria-label="Próximo mês">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="cal-widget__weekdays" aria-hidden="true">
                        <span>S</span>
                        <span>T</span>
                        <span>Q</span>
                        <span>Q</span>
                        <span>S</span>
                        <span>S</span>
                        <span>D</span>
                    </div>

                    <div class="cal-widget__days" data-calendar-grid></div>
                </div>

                <div class="cal-events-panel" data-events-panel>
                    <div class="cal-events-panel__inner" data-panel-inner>
                        <?php $renderEventCard($upcomingTwo[0] ?? null, 'is-large', 'Próximo evento'); ?>
                        <?php $renderEventCard($upcomingTwo[1] ?? null, 'is-small', 'Evento em destaque'); ?>
                    </div>
                </div>
            </div>

            <div class="cal-gallery-band">
                <div class="container-xl cal-gallery-wrap">
                    <h2>Galeria</h2>

                    <div class="cal-gallery-grid">
                        <figure class="cal-gallery-item is-side">
                            <img src="<?= $basePath; ?>/assets/img/home_yara.jpg" alt="Cães durante uma cãominhada no parque">
                        </figure>

                        <figure class="cal-gallery-item is-main">
                            <img src="<?= $basePath; ?>/assets/img/home_zeus.webp" alt="Participantes e animais num encontro comunitário">
                        </figure>

                        <figure class="cal-gallery-item is-side">
                            <img src="<?= $basePath; ?>/assets/img/home_mike.avif" alt="Momento de convívio com animais em evento">
                        </figure>
                    </div>
                </div>
            </div>
        </section>
<?php
        $stmtUpcoming->close();
    endif;
