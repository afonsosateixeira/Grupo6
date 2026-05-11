<section class="container my-5" style="max-width: 520px;">
	<h1 class="mb-4">Entrar</h1>
	<form method="POST" class="border rounded-3 p-4 bg-light">
		<div class="mb-3">
			<label class="form-label" for="email">Email</label>
			<input type="email" name="email" id="email" class="form-control" placeholder="email@exemplo.com">
		</div>
		<div class="mb-3">
			<label class="form-label" for="pass">Palavra-passe</label>
			<input type="password" name="pass" id="pass" class="form-control" placeholder="********">
		</div>
		<button type="submit" class="btn btn-primary w-100">Entrar</button>
		<?= $response ?>
	</form>
</section>