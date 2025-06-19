<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'empresa') {
    header("Location: ../../index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Painel da Empresa</title>
</head>
<body>

  <h2>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h2>

  
  <p>Aqui é a "tela da empresa", apenas pra provar q fez login e testar as funcionalidades</p>

  <form action="../excluir_conta.php" method="post">
    <p><input type="submit" value="Excluir conta"></p>
  </form>
  
  <p><a href="../logout.php">Sair</a></p>

</body>
</html>
