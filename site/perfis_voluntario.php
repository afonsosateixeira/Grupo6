<?php
    if (!$rerun):
        $metaTitle = 'Perfis de voluntarios';
        $metaDescription = 'Regista-te para seres voluntário';

    // ====================================================================
    // 2. PROCESSAMENTO DE DADOS (Executa em silêncio antes do HTML)
    // ====================================================================
    else:
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_submeter'])) {
            
            // Recupera o user_id se faltar na sessão
            if (!isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
                $sql_id = "SELECT id FROM users WHERE email = '" . $_SESSION['email'] . "'";
                $res_id = $conn->query($sql_id);
                if ($res_id->num_rows > 0) {
                    $linha_id = $res_id->fetch_assoc();
                    $_SESSION['user_id'] = $linha_id['id'];
                }
            }

            if (isset($_SESSION['user_id'])) {
                $user_id     = $_SESSION['user_id'];
                $localidade  = $_POST['localidade'];
                $dia_semana  = $_POST['diasdasemana'];
                $hora_inicio = $_POST['hora_inicio'];
                $hora_fim    = $_POST['hora_fim'];

                // I. Atualiza a localidade
                $sql_update_user = "UPDATE users SET local = '$localidade' WHERE id = $user_id";
                $conn->query($sql_update_user);

                // II. Verifica ou cria perfil
                $sql_check_profile = "SELECT id FROM volunteer_profiles WHERE user_id = $user_id";
                $res_profile = $conn->query($sql_check_profile);
                
                if ($res_profile->num_rows === 0) {
                    $sql_ins_prof = "INSERT INTO volunteer_profiles (user_id) VALUES ($user_id)";
                    $conn->query($sql_ins_prof);
                    $volunteer_id = $conn->insert_id;
                } else {
                    $profile_data = $res_profile->fetch_assoc();
                    $volunteer_id = $profile_data['id'];
                }

                // III. Insere o turno
                $sql_shift = "INSERT INTO volunteer_shifts (volunteer_id, day_week, start_time, end_time) 
                              VALUES ($volunteer_id, '$dia_semana', '$hora_inicio', '$hora_fim')";
                
                $gravado_com_sucesso = $conn->query($sql_shift);
            }
        }
    ?>
        <div class="container">
            <?php


        
        // Se NÃO está logado -> Mostra a mensagem de aviso controlada
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true):
    ?>
            <div class="container text-center my-5">
                <p class="fs-5">Cria ou inicia sessão para aceder ao formulário.</p>
                <div class="mt-4">
                    <a href="regist.php?redirect=perfis_voluntario">
                        <button class="botao_regist">Registrar</button>
                    </a>
                    <a href="login.php?redirect=perfis_voluntario">
                        <button class="botao_login">Login</button>
                    </a>
                </div>

    <?php
        // Se ESTÁ logado -> Mostra o formulário
        else:
    ?>
            <div class="container">
 <form action="" method="POST">
        <div class="campo">
          <div class="mb-3">
            <label for="localidade" class="form-label">Localidade</label>
            <input type="text" class="form-control" id="localidade" name="localidade" required>
          </div>
        </div>

        <div class="mb-3">
          <div class="dia_semana">
            <p>Dia da semana</p>
            <select name="diasdasemana" id="diasdasemana" required>
              <option>Selecione uma opção</option>
              <option value="Segunda-feira">Segunda-feira</option>
              <option value="Terça-feira">Terça-feira</option>
              <option value="Quarta-feira">Quarta-feira</option>
              <option value="Quinta-feira">Quinta-feira</option>
              <option value="Sexta-feira">Sexta-feira</option>
              <option value="Sábado">Sabado</option>
              <option value="Domingo">Domingo</option>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <div class="horario">
            <p>Horário inicio</p>
            <select name="hora_inicio" id="hora_inicio" required>
              <option>Selecione uma opção</option>
              <option value="08:30:00">08:30</option>
              <option value="10:30:00">10:30</option>
              <option value="11:00:00">11:00</option>
              <option value="13:00:00">13:00</option>
              <option value="15:00:00">15:00</option>
              <option value="17:00:00">17:00</option>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <div class="horario">
            <p>Horário fim</p>
            <select name="hora_fim" id="hora_fim" required>
              <option>Selecione uma opção</option>
              <option value="08:30:00">08:30</option>
              <option value="10:30:00">10:30</option>
              <option value="11:00:00">11:00</option>
              <option value="13:00:00">13:00</option>
              <option value="15:00:00">15:00</option>
              <option value="17:00:00">17:00</option>
            </select>
          </div>
        </div>
        <button type="submit" name="btn_submeter" class="botao_tornate">Torna-te voluntário</button>
      </form>
            </div>
    <?php
        endif;


            if (isset($gravado_com_sucesso) && $gravado_com_sucesso) {
                echo "<div class='alert alert-success text-center my-3'>Inscrição gravada com sucesso!</div>";
            } elseif (isset($gravado_com_sucesso) && !$gravado_com_sucesso) {
                echo "<div class='alert alert-danger text-center my-3'>Erro ao guardar dados.</div>";
            }

            // Listagem das cartas
            $sql = "SELECT * FROM vw_volunteer_simple_schedule";
            $lista = $conn->query($sql);
            ?>
            <div class="text-center my-5">
                <h2>Perfil dos voluntários</h2>
            </div>
            
            <div class="cartas d-flex flex-wrap justify-content-center gap-3 mb-5">
                <?php while($voluntario = $lista->fetch_assoc()): ?>
                    <div class="card" style="width: 18rem">
                        <div class="card-body text-center">
                            <h3 class="card-title"><?= htmlspecialchars($voluntario['volunteer_name']) ?></h3>
                            <p class="card-text text-start"><strong>Horário:</strong><br>
                                <?= htmlspecialchars($voluntario['day_week']) ?> – 
                                <?= date('H:i', strtotime($voluntario['start_time'])) ?> até 
                                <?= date('H:i', strtotime($voluntario['end_time'])) ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php
    endif; 
    ?>