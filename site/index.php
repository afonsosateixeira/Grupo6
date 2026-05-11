<?php
	# Inicia a sessão e faz ligação à base de dados 
	require_once 'db.php';

	# Vai buscar a última parte do url(a página atual)
	$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
	$path = basename($path);
	$path = pathinfo($path, PATHINFO_FILENAME);

	#Verifica se a página atual devia ficar como index ou como identificado anteriormente
	$route = ($path === 'site' || $path === '') ? 'index' : $path;

	# Se entrares numa página usando um get redirect (útil para formulários que necessitam de sessão iniciada) automáticamente voltas á página
	if(!empty($_GET['redirect'])){
		header('Location: ./'.$_GET['redirect']);
		exit();
	}

	# No caso de ser necessário usar uma mensagem
	$response = $_GET['response'] ?? '';

	# Switch case para definir o título e a descrição(google/etc) das páginas
	switch ($route) {
		case 'accessibility':
			$metaTitle = 'Acessibilidade';
			$metaDescription = 'Informações sobre acessibilidade';
			break;

		case 'adoptionGuide':
			$metaTitle = 'Guia de Adoção';
			$metaDescription = 'Guia passo a passo para adoção responsável';
			break;

		case 'animal_care':
			$metaTitle = 'Cuidados animais';
			$metaDescription = 'Informação de vacinas para saúde animal';
      		break;

		case 'animalCatalog':
			$metaTitle = 'Catálogo de Animais';
			$metaDescription = 'Animais disponíveis para adoção';
			break;

		case 'animalDetails':
			$metaTitle = 'Detalhes'; #No caso de preferires podes tentar utilizar uma variável e pesquisar a base de dados para introduzir o nome do animal específico.
			$metaDescription = 'Todas as informações do animal';
			break;

		case 'appointment':
			$metaTitle = 'Agendar Consulta';
			$metaDescription = 'Agende uma consulta para o seu animal de estimação';
			break;

		case 'contactos':
			$metaTitle = 'Contactos';
			$metaDescription = 'Contactos da Poppy and Max';
      		break;

		case 'cookies':
			$metaTitle = 'Política de Cookies';
			$metaDescription = 'Política de Cookies da Poppy and Max';
			break;

		case 'dia_voluntario':
			$metaTitle = 'Dia no Abrigo';
			$metaDescription = 'Um dia como voluntário';
			break;

		case 'forbidden':
			# Se a resposta que vem do backoffice for um desses erros executa o código de erro correspondente
			if($response == 401 || $response == 403){
				http_response_code($response);
				$metaTitle = 'Acesso negado';
				$metaDescription = 'Não têm permição para aceder à página pretendida';
				break;
			}
			# Caso contrário declara que a página não foi encontrada para evitar esta página a menos que seja por falta de autorizações
			http_response_code(404);
			$metaTitle = 'Página não encontrada';
			$metaDescription = 'A página que procura não existe';
			break;

		case 'index':
			$metaTitle = '';
			$metaDescription = 'Página inicial da Poppy and Max';
			break;

		case 'login':
			# Verifica se a página foi aberta através do formulário ser preenchido, atribuindo os valores preenchidos a variáveis
			if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$email = trim($_POST['email']);
				$pass = hash('sha512', trim($_POST['pass']));

				# Verifica se falta algum campo ser preenchido mandando um aviso se faltar, caso todos estiverem preenchidos verifica se existe algum resultado de um utilizador com o email inserido
				if(!empty($email) && !empty($pass)){
					$stmt = $conn->prepare('SELECT full_name, email, password FROM users WHERE email = ?');
					$stmt->bind_param('s', $email);
					$stmt->execute();
					$res = $stmt->get_result();

					# Se existir um utilizador onde o email seja igual ao inserido verifica a pass e inicia a sessão se esta também estiver correta, senão dá erros correspondentes
					if($row = $res->fetch_assoc()){
						if($row['password'] === $pass){
							$_SESSION['auth'] = true;
							$_SESSION['email'] = $row['email'];

							# Guarda o nome com apenas o primeiro e último nomes, se este existir, ou apenas o primeiro nome
							$name = preg_split('/\s+/', trim($row['full_name']));
							if(count($name) == 1)
								$name = $name[0];
							else
								$name = $name[0].' '.$name[count($name) -1];
							$_SESSION['user'] = $name;
						} else
							$response = '<p class="fw-bold mt-2 mb-0">Password incorreta!</p>';
					} else
						$response = '<p class="fw-bold mt-2 mb-0">Esse email não está registado!</p>';
				} else
					$response = '<p class="fw-bold mt-2 mb-0">Preencha todos os campos para entrar!</p>';
			}

			# Verifica se o utilizador já está autenticádo, se sim redireciona para a página inicial
			if(!empty($_SESSION['auth'])){
				header('Location: ./');
				exit();
			}

			$metaTitle = 'Iniciar Sessão';
			$metaDescription = 'Acesso à conta';
			break;

		# Destroi a sessão e redireciona para o login no caso de fazer logout
		case 'logout':
			session_destroy();
			header('Location: ./login');
			exit();
			break;

		case 'privacy':
			$metaTile = 'Politicas de Privacidade';
			$metaDescription = 'Politcas de Privacidade da Poppy and Max';
			break;

		case 'regist':
			# Verifica se a página foi aberta através do formulário ser preenchido, atribuindo os valores preenchidos a variáveis
			if($_SERVER['REQUEST_METHOD'] === 'POST'){
				$name = trim($_POST['name']);
				$email = trim($_POST['email']);
				$pass = hash('sha512', trim($_POST['pass']));
				$contact = trim($_POST['number']);

				# Verifica se falta algum campo ser preenchido mandando um aviso se faltar, caso todos estarem preenchidos verifica se o email inserido é igual ao que o utilizador está a tentar registar
				if(!empty($name) && !empty($email) && !empty($pass) && !empty($contact)){
					$stmt = $conn->prepare('SELECT email FROM users WHERE email = ?');
					$stmt->bind_param('s', $email);
					$stmt->execute();
					$res = $stmt->get_result();

					# Se existir algum email igual dá um aviso, se não cria uma conta e inicia a sessão com a mesma
					if($res->num_rows > 0)
						$response = '<p class="fw-bold mt-2 mb-0">Esse email já está em uso!</p>';
					else{
						$stmt = $conn->prepare('INSERT INTO users(full_name, email, password, phone) VALUES(?, ?, ?, ?)');
						$stmt->bind_param('ssss', $name, $email, $pass, $contact);
						$stmt->execute();

						$_SESSION['auth'] = true;
						$_SESSION['email'] = $email;

						# Guarda o nome com apenas o primeiro e último nomes, se este existir, ou apenas o primeiro nome
						$name = preg_split('/\s+/', $name);
						if(count($name) == 1)
							$name = $name[0];
						else
							$name = $name[0].' '.$name[count($name) -1];
						$_SESSION['user'] = $name;
					}
				} else
					$response = '<p class="fw-bold mt-2 mb-0">Preencha todos os campos de registo!</p>';
			}

			# Verifica se o utilizador já está autenticádo, se sim redireciona para a página inicial
			if(!empty($_SESSION['auth'])){
				header('Location: ./');
				exit();
			}

			$metaTitle = 'Registar';
			$metaDescription = 'Crie a sua conta';
			break;

		case 'termos':
			$metaTitle = 'Termos e condições';
			$metaDescription = 'Termos e condições da Poppy and Max';
			break;	

		default:
			http_response_code(404);
			$metaTitle = 'Página não encontrada';
			$metaDescription = 'A página que procura não existe';
			break;
	}
?>

<!DOCTYPE html>
<html lang="pt">
	<head>
		<?php
			# Vai buscar o código todo que útilizamos para o head como chamar o css e javascript
			require_once 'components/head.php';
		?>
	</head>
	<body>
		<?php
			# Vai buscar o nosso header/navbar
			require_once 'components/header.php';
		?>
		<main>
			<?php
				# Switch case para decidir a página que é apresentada no nosso site
				switch ($route) {
					case 'accessibility':
						require_once 'accessibility.html';
						break;

					case 'adoptionGuide':
						require_once 'adoptionGuide.html';
						break;

					case 'animal_care':
						require_once 'animal_care.php';
						break;

					case 'animalCatalog':
						require_once 'animalCatalog.php';
						break;

					case 'animalDetails':
						require_once 'animalDetails.php';
						break;

					case 'appointment':
						require_once 'appointment.php';
						break;

					case 'contactos':
						require_once 'contactos.html';
						break;

					case 'cookies':
						require_once 'cookies.html';
						break;

					case 'dia_voluntario':
						require_once 'dia_voluntario.html';
						break;

					case 'forbidden':
						if($response == 401 || $response == 403)
							require_once 'forbidden.php';
						else
							require_once '404.html';
						break;

					case 'index':
						require_once 'home.php';
						break;

					case 'login':
						require_once 'login.php';
						break;

					case 'privacy':
						require_once 'privacy.html';
						break;

					case 'regist':
						require_once 'regist.php';
						break;

					case 'termos':
						require_once 'termos.html';
						break;

					default:
						require_once '404.html';
						break;
				}
			?>
		</main>
	<?php
		# Vai buscar o nosso footer
		require_once 'components/footer.php';
	?>
	</body>
</html>