<?php
    if(!$rerun):
        $metaTitle = 'Eventos';
        $metaDescription = 'Calendario de eventos da Poppy and Max';
    else:
        $stmt = $conn->prepare("SELECT id, name, event_date, end_date, location, description, event_type, status, capacity FROM events ORDER BY event_date ASC");
        $stmt->execute();
        $events = $stmt->get_result();
?>
        <section class="container py-5">
            <div class="text-center mb-5">
                <h1 class="fw-bold mb-2">Calendario de Eventos</h1>
            </div>

            <?php if($events->num_rows === 0): ?>
                <div class="alert alert-info text-center">Nao existem eventos disponiveis de momento.</div>
            <?php else: ?>
                <div class="row g-4">
                    <?php while($event = $events->fetch_assoc()): ?>
                        <?php
                            $startTimestamp = strtotime($event['event_date']);
                            $endTimestamp = strtotime($event['end_date'] ?? '') ?: null;
                            $dateEnd = date('H:i',$endTimestamp);
                            $statusLabel = $event['status'] === 'scheduled'
                                ? 'Agendado'
                                : ($event['status'] === 'completed'
                                    ? 'Concluido'
                                    : ($event['status'] === 'cancelled' ? 'Cancelado' : 'Adiado'));
                            $statusClass = $event['status'] === 'scheduled'
                                ? 'bg-success'
                                : ($event['status'] === 'completed'
                                    ? 'bg-secondary'
                                    : ($event['status'] === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark'));
                        ?>
                        <div class="col-12 col-lg-6">
                            <article class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex flex-row align-items-center p-4 gap-4">
                                    <?php
                                        $month = strtoupper(date('M', $startTimestamp));
                                        $day = date('d', $startTimestamp);
                                    ?>
                                    <div class="d-flex flex-column align-items-center me-3" style="width:110px;min-width:110px;max-width:110px;">
                                        <span class="badge mb-2 w-100 text-center <?= $statusClass ?>">
                                            <?= htmlspecialchars($statusLabel); ?>
                                        </span>
                                        <div class="d-flex flex-column align-items-center justify-content-center border rounded-3 p-2 mb-1" style="min-width:64px;background:#f5fbff;border:1.5px solid #b6d0ee;box-shadow:0 2px 8px rgba(19,94,177,0.07);">
                                            <div class="fw-bold text-uppercase text-primary small" style="letter-spacing:1.5px;"><?= $month ?></div>
                                            <div class="fw-bold fs-3 text-dark"><?= $day ?></div>
                                        </div>
                                        <div class="small text-muted text-center">
                                            <?= date('Y', $startTimestamp) ?>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h2 class="mb-1 fs-4 fw-bold text-dark"><?= htmlspecialchars($event['name']); ?></h2>
                                        <p class="mb-2 text-muted small"><?= !empty($event['description']) ? htmlspecialchars($event['description']) : 'Sem descricao disponivel.'; ?></p>
                                        <div class="mb-2">
                                            <span class="text-uppercase small text-secondary">Início:</span>
                                            <span class="fw-bold text-primary ms-1"><?= date('H:i', $startTimestamp); ?></span>
                                            <?php if(!empty($dateEnd)): ?>
                                                <span class="mx-2 text-secondary">até</span>
                                                <span class="fw-bold text-primary ms-1"><?= $dateEnd; ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-2">
                                            <span class="me-3"><strong>Local:</strong> <?= htmlspecialchars($event['location']); ?></span>
                                            <?php if(!empty($event['capacity'])): ?>
                                                <span><strong>Capacidade:</strong> <?= (int)$event['capacity']; ?> participantes</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-2">
                                            <span class="me-3"><strong>Tipo:</strong> <?= htmlspecialchars($event['event_type']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </section>
<?php
        $events->free();
        $stmt->close();
    endif;
