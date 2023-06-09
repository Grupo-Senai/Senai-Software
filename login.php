<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/ico" href="config/assets/img/baixar.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="config/assets/estilos/login.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Fira+Sans:ital,wght@1,200&family=Montserrat:wght@200&family=Source+Sans+Pro&display=swap" rel="stylesheet">
  <title>Login</title>
</head>

<body>

  <div id="app">

    <form id="forms" action="./conexaologin.php" method="post" onsubmit="exibirAlerta(event)">

      <div class="link-container">
        <a href="cadastro.php" class="link-button1">CRIAR CADASTRO</a>
      </div>

      <h1>LOGIN</h1>

      <label for="nome"></label>
      <input type="text" maxlength="42" id="nome" name="usuario" placeholder="Digite seu E-mail / CPF / ID" required onfocus="this.placeholder = ''" onblur="this.placeholder = 'Digite seu E-mail / CPF / ID'" style="text-align: left;"><br>

      <label for="curso"></label>
      <input type="password" minlength="8" maxlength="62" id="senha" name="senha" placeholder="Digite sua senha" required onfocus="this.placeholder = ''" onblur="this.placeholder = 'Digite seu E-mail / CPF / ID'" style="text-align: left;">

      <div class="link-container">
        <a href="passwrecovery.php" class="link-button2">RECUPERAR SENHA</a>
      </div>

      <div class="button-container">
        <button type="submit" value="ACESSAR">ACESSAR</button>

        <button type="button" id="botao_limpar" onclick="limparFormulario()" class="limpar-button">LIMPAR FORMULÁRIO</button>

      </div>

  </div>
  </form>
  <?php
  if (isset($_GET['error']) && $_GET['error'] == '1001') {
    echo "<div class='failed' style='text-align: center; font-size:20px; font-weight:600;'>Login ou senha inválidos.</div>";
  }
  ?>
  </div>
  <script>
    function limparFormulario() {
      document.getElementById("forms").reset();

      // Limpar manualmente os campos de texto
      var dados = document.querySelectorAll('#forms input[type="text"]');
      for (var i = 0; i < dados.length; i++) {
        dados[i].value = '';
      }
    }

    function clearPlaceholder(element) {
      element.placeholder = '';
    }

    function resetPlaceholder(element) {
      element.placeholder = 'Digite seu E-mail / CPF / ID';
    }
  </script>
  <script src="./config/assets/js/destruirSessao.js"></script>
  <script src="./config/assets/js/default.js"></script>
  <footer>
    <div class="rodape">
      <p>&copy; 2023 UAIBook. Todos os direitos reservados.</p>
      <p>Curso de Desenvolvimento de Sistemas, Uberaba/MG, SENAI</p>
    </div>
  </footer>
</body>



</html>