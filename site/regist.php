<section class="container my-5" style="max-width: 620px;">
	<h1 class="mb-4">Registar</h1>
	<form method="POST" class="border rounded-3 p-4 bg-light">
		<div class="mb-3">
			<label class="form-label" for="name">Nome</label>
			<input type="text" name="name" id="name" class="form-control" placeholder="Nome completo">
		</div>
		<div class="mb-3">
			<label class="form-label" for="email">Email</label>
			<input type="email" name="email" id="email" class="form-control" placeholder="email@exemplo.com">
		</div>
		<div class="mb-3">
			<label class="form-label" for="pass">Palavra-passe</label>
			<input type="password" name="pass" id="pass" class="form-control" placeholder="********">
		</div>
		<div class="mb-3">
			<label class="form-label" for="phone">Telemóvel</label>
			<input type="text" name="number" id="phone" class="form-control" placeholder="+351 999999999">
		</div>
		<!-- Maybe add a button as an option to add more stuff such as birthday/etc-->
		<button type="submit" class="btn btn-primary w-100">Criar conta</button>
		<?= $response ?>
	</form>
</section>