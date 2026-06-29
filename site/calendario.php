<?php
    if(!$rerun):
        $metaTitle = 'Calendário de Eventos';
        $metaDescription = 'Calendário com os próximos eventos e galeria da comunidade Poppy and Max';
    else:
        $stmtUpcoming = $conn->prepare("SELECT id, name, event_date, location, event_type FROM events WHERE event_date >= CURDATE() AND status != 'cancelled' ORDER BY event_date ASC");
        $stmtUpcoming->execute();
        $upcomingEvents = $stmtUpcoming->get_result()->fetch_all(MYSQLI_ASSOC);

        $upcomingTwo = array_slice($upcomingEvents, 0, 2);

        $monthFullLabels = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];

        $monthShortLabels = [
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

        $eventDates = [];
        $allEventsByDate = [];
        foreach($upcomingEvents as $ev){
            $ts = strtotime($ev['event_date']);
            $isoDate = date('Y-m-d', $ts);
            $eventDates[] = $isoDate;
            $allEventsByDate[$isoDate][] = [
                'name'       => $ev['name'],
                'date_label' => date('d', $ts).' '.($monthShortLabels[date('m', $ts)] ?? strtoupper(date('M', $ts))),
                'location'   => $ev['location'],
                'image'      => $basePath.'/'.$eventCoverImage($ev['name'], $ev['event_type']),
            ];
        }
        $eventDates = array_values(array_unique($eventDates));

        $renderEventCard = function (?array $event, string $sizeClass, string $fallbackTitle) use ($basePath, $eventCoverImage, $monthShortLabels): void {
            if(empty($event)){
                $cover = $basePath.'/assets/img/poppy_max.png';
                $dateLabel = '-- ---';
                $locationLabel = 'Parque Canino Leiria';
                $titleLabel = $fallbackTitle;
            } else {
                $timestamp = strtotime($event['event_date']);
                $monthKey = date('m', $timestamp);
                $dateLabel = date('d', $timestamp).' '.($monthShortLabels[$monthKey] ?? strtoupper(date('M', $timestamp)));
                $locationLabel = $event['location'];
                $titleLabel = $event['name'];
                $cover = $basePath.'/'.$eventCoverImage($event['name'], $event['event_type']);
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
                        <h1 data-calendar-month><?= $monthFullLabels[(int)date('n')] ?? date('F'); ?></h1>
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
