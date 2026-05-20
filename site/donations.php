<?php
	if(!$rerun):
		$metaTile = 'Painel de Doações';
		$metaDescription = 'Painel de Doações da Poppy and Max';
	else:
        $sql = "SELECT * FROM donations ORDER BY amount DESC LIMIT 4";
        $result = $conn->query($sql);
        $conn->close();
?>
    <section class="container-fluid py-5">
    	<div class="mx-auto text-center col-10 col-md-8">
        	<h1 class="display-4 fw-bold fs-1">Ajuda-nos a dar uma segunda vida a animais abandonados</h1>
        	<p class="lead">Cada doação garante cuidados, abrigo e uma nova oportunidade</p>
    	</div>
	</section>

	<section class="background">
		<div class="container py-4">
    		<div class="row align-items-center g-4">
            	<div class="col-12 col-lg-5">
            		<form>
                		<div class="mb-3">
                    		<label for="amount" class="form-label text-white">Valor da Doação</label>
                    		<input type="number" class="form-control" id="amount" placeholder="0.00">
                		</div>

                		<div class="btn-group btn-group-custom w-100 mb-4" data-toggle="buttons">
                    		<input type="radio" class="btn-check" id="btn-check" name="donationMethod" value="MBway" autocomplete="off">
                    		<label class="btn btn-outline-dark" for="btn-check">MBWay</label>
                    
                    		<input type="radio" class="btn-check" id="btn-check-2" name="donationMethod" value="Transferência" autocomplete="off">
                    		<label class="btn btn-outline-dark" for="btn-check-2">Transferência</label>
                    
                		</div>
                
                		<div class="d-grid gap-2">
                    		<button class="btn btn-custom" type="button">Enviar Doação</button>
                		</div>
            		</form>
        		</div>

				<div class="col-12 col-lg-7">
    				<div class="position-relative overflow-hidden rounded shadow text-white">
        				<img src="assets/img/donations_banner.jpg" class="img-fluid w-100 h-100 object-fit-cover" alt="Doação Banner" style="min-height: 250px;">
        				<div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
        			<div class="position-absolute top-50 start-50 translate-middle text-center w-100 px-3">
            			<h3 class="fw-bold m-0 fs-4 text-uppercase tracking-wide">Mais de 5000€ já foram doados para dar novas casas aos nossos amigos patudos</h3>
        			</div>
    				</div>
				</div>
    		</div>
		</div>
	</section>
	<section class="container my-4">
		<div class="row g-4">
			<h3 class="display-6 fw-bold text-center mb-4">Top Doações</h3>
  				
				<?php if ($result->num_rows > 0): ?>
                <?php foreach ($result as $donation): ?>
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-custom h-100 border-0">
                            <div class="card-body text-center">
                                <h4 class="card-title fw-bold text-dark display-6 mb-3">
                                    <?= $donation['amount'] ?>€
                                </h4>
                                <p class="card-text text-muted small mb-1">
                                	Metodo de doação: <?= htmlspecialchars($donation['payment_method']) ?>
                                </p>
                                <p class="card-text text-muted extreme-small">
                                	<i class="bi bi-calendar3"></i> <?= date('d/m/Y', strtotime($donation['donation_date'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>

                <div class="col-12 text-center">
                    <p class="text-muted">Ainda não existem doações registadas. Seja o primeiro!</p>
                </div>
            <?php endif; ?>
  		</div>
	</section>
<?php
    endif;
?>