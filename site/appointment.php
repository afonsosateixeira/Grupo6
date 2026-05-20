<?php
if (!$rerun):
	$metaTitle = 'Agendar Consulta';
	$metaDescription = 'Agende uma consulta para o seu animal de estimação';
else:

	$sql = "SELECT name as nome_vet FROM veterinarians ORDER BY id LIMIT 3";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$res = $stmt->get_result();
?>

	<section class="ban">
		<div>
			<h2 class="text-light">O primeiro passo para uma amizade eterna começa com saúde.</h2>
			<p class="text-light">Vamos garantir que o seu melhor amigo continue esta nova jornada com a pata direita.</p>
		</div>
		<a href="#appointment"><button class="bg-light" onclick="irParaConsulta()">
				Agendar Consulta
			</button></a>
	</section>
	<div class="container">
		<section>
			<h2 class="text-center my-4">Por que o Check-up é Essencial?</h2>
			<div class="row column-gap-3 row-gap-3 justify-content-center">
				<div class="col-12 col-lg-auto p-0">
					<div class="card rounded-4 mx-auto">
						<img src="assets/img/appointment_saude.png" class="card-img-top vacina mx-auto mt-4" alt="Saude">
						<div class="card-body text-center p-4">
							<h4 class="fw-semibold">Histórico de Saúde:</h4>
							<p class="mb-0">Entender o passado médico do animal (vacinas, vermifugação e zoonoses).</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-auto p-0">
					<div class="card sabiaCard2 rounded-4 mx-auto">
						<img src="assets/img/appointment_prevenção.png" class="card-img-top mx-auto mt-4" alt="Bactérias">
						<div class="card-body text-center p-4">
							<h4 class="fw-semibold">Prevenção:</h4>
							<p class="mb-0">Identificar antecipadamente as condições que podem ser tratadas antes de se tornarem graves.</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-auto p-0">
					<div class="card rounded-4 mx-auto">
						<img src="assets/img/appointment_segurança.png" class="card-img-top mx-auto mt-4" alt="Custos">
						<div class="card-body text-center p-4">
							<h4 class="fw-semibold">Segurança da Família:</h4>
							<p class="mb-0">Garantir que não existam parasitas que possam afetar os humanos da casa.</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section>
			<h2 class="text-center my-4" id="appointment">Agende o seu check-up</h2>
			<form id="appointment-form" method="post" action="appointment.php">
				<div class="row column-gap-3 row-gap-3 justify-content-center">
					<div class="col-12 col-md-auto p-3">
						<div class="custom-bg-blue text-light rounded-top-4 p-1">
							<p class="text-center fw-semibold my-4">1-Sobre o animal</p>
						</div>
						<div class="rounded-bottom-4 p-4">
							<div class="mb-3 d-flex flex-wrap justify-content-center">
								<div>
									<input type="radio" name="animal" value="cão" id="dog" class="btn-check">
									<label for="dog" class="animal-label">
										<img src="assets/img/appointment_dog.png" class="animal" alt="dog">
									</label>
								</div>

								<div>
									<input type="radio" name="animal" value="gato" id="cat" class="btn-check">
									<label for="cat" class="animal-label">
										<img src="assets/img/appointment_cat.png" class="animal" alt="cat">
									</label>
								</div>

								<div>
									<input type="radio" name="animal" value="outro" id="other" class="btn-check">
									<label for="other" class="animal-label">
										<img src="assets/img/appointment_paw.png" class="animal" alt="paw">
									</label>
								</div>
							</div>

							<div class="mb-3">
								<label for="name_animal" class="form-label">Qual é o nome do animal?</label>
								<input type="text" name="name_animal" class="form-control" id="name_animal">
							</div>
							<div class="mb-3">
								<label for="age_animal" class="form-label">Qual é a idade do animal?</label>
								<input type="number" name="age_animal" class="form-control" id="age_animal">
							</div>
							<div class="mb-3">
								<label for="breed_animal" class="form-label">Qual é a raça do animal?</label>
								<input type="text" name="breed_animal" class="form-control" id="breed_animal">
							</div>
						</div>
					</div>
					<div class="col-12 col-md-auto p-3">
						<div class="custom-bg-blue text-light rounded-top-4 p-1">
							<p class="text-center fw-semibold my-4">2-Horário Disponíveis</p>
						</div>
						<div class="rounded-bottom-4 p-4">
							<div class="row">
								<div class="col-6"><input type="date" name="data_consulta" class="form-control"></div>
								<div class="col-6">
									<p>Horas disponivel</p>
									<div>
										<input type="radio" name="horary" value="10:00:00" id="time_10" class="btn-check">
										<label for="time_10" class="time-label">10:00</label>
									</div>

									<div>
										<input type="radio" name="horary" value="15:00:00" id="time_15" class="btn-check">
										<label for="time_15" class="time-label">15:00</label>
									</div>

									<div>
										<input type="radio" name="horary" value="18:00:00" id="time_18" class="btn-check">
										<label for="time_18" class="time-label">18:00</label>

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-auto p-3">
						<div class="custom-bg-blue text-light rounded-top-4 p-1">
							<p class="text-center fw-semibold my-4">3-Resumo</p>
						</div>
						<div class="rounded-bottom-4 d-flex flex-column p-4">

							<p>Pet: <span id="resumo-pet-name"></span> (<span id="resumo-pet-age"></span> anos, </span> <span id="resumo-animal-type"></span> <span id="resumo-breed"></span>)</p> 
							<p>Data da consulta: <span id="resumo-date"></span></p> 
							<p>Hora da consulta: <span id="resumo-time"></span></p>
							<p>Valor a pagar: 30.00€</p>
							<button type="submit" class="custom-bg-blue text-light rounded-4 p-2">
								Agendar Consulta
							</button>
						</div>
					</div>
			</form>
		</section>
	</div>
<?php
endif;
