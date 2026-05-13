<?php
	if(!$rerun):
		http_response_code($response);
		$metaTitle = 'Acesso negado';
		$metaDescription = 'Não têm permição para aceder à página pretendida';
	else:
?>
		<section class="container my-5">
			<h1>Accesso negado</h1>
			<p><?= $response == 401 ? "Inicie a sua conta antes de tentar aceder a esta página" : "Não têm permições para aceder a esta página" ?></p>
		</section>
<?php
    endif;