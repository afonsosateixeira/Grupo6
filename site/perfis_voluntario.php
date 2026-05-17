  <div class="container">
<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!$rerun):
      $metaTitle = 'Perfis de voluntarios';
      $metaDescription = 'Regista-te para seres voluntário';

    else:
      if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true):
        
    ?>
      <div class="text-center my-5">
        <p>Cria ou inicia sessão para aceder ao formulário.</p>
        <div class="mt-4">
        <a href="login.php?redirect=perfis_voluntario">
        <button class="botao_login">Login</button>
        </a>
        <a href="regist.php?redirect=perfis_voluntario">
        <button class="botao_regist">Registrar</button>
        </a>
        </div>
      </div>

    <?php
      else:
    ?>
      <form>
        <div class="campo">
          <div class="mb-3">
            <label for="exampleInputTelemovel" class="form-label">Telemovel</label>
            <input type="tel" class="form-control" id="exampleInputTelemovel">
          </div>
        </div>
        <div class="campo">
          <div class="mb-3">
            <label for="exampleInputText" class="form-label">Localidade</label>
            <input type="text" class="form-control" id="exampleInputText">
          </div>
        </div>

        <div class="mb-3">
          <div class="dia_semana">
            <p>Dia da semana</p>
            <select name="diasdasemana">
              <option>Selecione uma opção</option>
              <option value="segundafeira">Segunda-feira</option>
              <option value="tercafeira">Terça-feira</option>
              <option value="quartafeira">Quarta-feira</option>
              <option value="quintafeira">Quinta-feira</option>
              <option value="sextafeira">Sexta-feira</option>
              <option value="sabado">Sabado</option>
              <option value="domingo">Domingo</option>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <div class="horario">
            <p>Horario inicio</p>
            <select name="diasdasemana">
              <option>Selecione uma opção</option>
              <option value="8:30">8:30</option>
              <option value="10:30">10:30</option>
              <option value="11:00<">11:00</option>
              <option value="13:00">13:00</option>
              <option value="15:00">15:00</option>
              <option value="17:00">17:00</option>
            </select>
          </div>
        </div>

        <div class="mb-3">
          <div class="horario">
            <p>Horario fim</p>
            <select name="diasdasemana">
              <option>Selecione uma opção</option>
              <option value="8:30">8:30</option>
              <option value="10:30">10:30</option>
              <option value="11:00<">11:00</option>
              <option value="13:00">13:00</option>
              <option value="15:00">15:00</option>
              <option value="17:00">17:00</option>
            </select>
          </div>
        </div>
        <button class="botao_submeter">Torna-te voluntário</button>
      </form>
    <?php
    endif; // Fecha o check da sessão
    endif;   // Fecha o check do $rerun
    ?>
  </div>