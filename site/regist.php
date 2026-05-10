<section class="container my-5" style="max-width: 620px;">
	<h1 class="mb-4">Registar</h1>
	<form method="POST" class="border rounded-3 p-4 bg-light">
		<div class="mb-3">
			<label class="form-label">Nome</label>
			<input type="text" name="name" class="form-control" placeholder="Nome completo">
		</div>
		<div class="mb-3">
			<label class="form-label">Email</label>
			<input type="email" name="email" class="form-control" placeholder="email@exemplo.com">
		</div>
		<div class="mb-3">
			<label class="form-label">Palavra-passe</label>
			<input type="password" name="pass" class="form-control" placeholder="********">
		</div>
		<div class="mb-3">
			<label class="form-label">Telemóvel</label>
			<input type="text" name="number" class="form-control" placeholder="+351 999999999">
		</div>
		<button type="submit" class="btn btn-primary w-100">Criar conta</button>
		<?= $response ?>
	</form>
</section>