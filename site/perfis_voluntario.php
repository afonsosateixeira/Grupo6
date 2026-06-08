<?php
    if (!$rerun):
        $metaTitle = 'Perfis de voluntarios';
        $metaDescription = 'Regista-te para seres voluntário';
    else:
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_submeter'])) {
            
            if (!isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
                $sql_id = "SELECT id FROM users WHERE email = '" . $_SESSION['email'] . "'";
                $res_id = $conn->query($sql_id);
                if ($res_id->num_rows > 0) {
                    $registo_id = $res_id->fetch_assoc();
                    $_SESSION['user_id'] = $registo_id['id'];
                }
            }

            if (isset($_SESSION['user_id'])) {
                $user_id     = $_SESSION['user_id'];
                $localidade  = trim($_POST['localidade'] ?? '');
                $dia_semana  = $_POST['diasdasemana'];
                $hora_inicio = $_POST['hora_inicio'];
                $hora_fim    = $_POST['hora_fim'];

                $sql_user_local = "SELECT local FROM users WHERE id = $user_id";
                $res_user_local = $conn->query($sql_user_local);
                $current_local = '';
                if ($res_user_local && $res_user_local->num_rows > 0) {
                    $row_user_local = $res_user_local->fetch_assoc();
                    $current_local = $row_user_local['local'];
                }

                if (empty($current_local) && $localidade !== '') {
                    $sql_update_user = "UPDATE users SET local = '$localidade' WHERE id = $user_id";
                    $conn->query($sql_update_user);
                }

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

                $sql_shift = "INSERT INTO volunteer_shifts (volunteer_id, day_week, start_time, end_time) VALUES ($volunteer_id, '$dia_semana', '$hora_inicio', '$hora_fim')";
                $gravado_com_sucesso = $conn->query($sql_shift);
            }
        }
    ?>
        <div class="container">
            <div class="text-center my-5">
                <h2><strong>Perfil dos voluntários</strong></h2>
            </div>
            <?php
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
        else:
    ?>
            <div class="container">
 <form action="" method="POST">
        <?php
            $showLocalInput = true;
            if (isset($_SESSION['user_id'])) {
                $sql_user_local = "SELECT local FROM users WHERE id = " . $_SESSION['user_id'];
                $res_user_local = $conn->query($sql_user_local);
                if ($res_user_local && $res_user_local->num_rows > 0) {
                    $current_local = $res_user_local->fetch_assoc()['local'];
                    if (!empty($current_local)) {
                        $showLocalInput = false;
                    }
                }
            }
        ?>
        <?php if ($showLocalInput): ?>
        <div class="campo">
          <div class="mb-3">
            <label for="localidade" class="form-label">Localidade</label>
            <input type="text" class="form-control" id="localidade" name="localidade" required>
          </div>
        </div>
        <?php endif; ?>

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

          <div class="horario">
            <div class="mb-3">
                <label class="form-label" for="hora_inicio">Hora Início</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
            </div>
          </div>


          <div class="horario">
            <div class="mb-3">
                <label class="form-label" for="hora_fim">Hora Fim</label>
                <input type="time" name="hora_fim" id="hora_fim" class="form-control" required>
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

            $sql = "SELECT volunteer_name, GROUP_CONCAT(CONCAT(day_week, ' ', DATE_FORMAT(start_time, '%H:%i'), ' até ', DATE_FORMAT(end_time, '%H:%i')) ORDER BY shift_id SEPARATOR '||') AS schedule
                    FROM vw_volunteer_simple_schedule
                    WHERE status = 'Aceite'
                    GROUP BY volunteer_name";
            $lista = $conn->query($sql);
            ?>
            
            <div class="cartas d-flex flex-wrap justify-content-center gap-3 mb-5 mt-5">
                <?php while($voluntario = $lista->fetch_assoc()): ?>
                    <div class="card" style="width: 18rem">
                        <div class="card-body text-center">
                            <h3 class="card-title"><?= htmlspecialchars($voluntario['volunteer_name']) ?></h3>
                            <p class="card-text text-start"><strong>Horários:</strong><br>
                                <?php foreach(explode('||', $voluntario['schedule']) as $shift): ?>
                                    <?= htmlspecialchars($shift) ?><br>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php
    endif; 
    ?>