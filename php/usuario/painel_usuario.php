<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'usuario') {
    header("Location: ../../index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Painel do Usuário</title>
</head>
<body>

  <h2>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h2>

  <p>Aqui é a "tela do usuario", apenas pra provar q fez login e testar as funcionalidades</p>
  <p>já que será tudo na tela inical</p>

  <p><a href="../logout.php">Sair</a></p>

</body>
</html>
