<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: index.html");
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
  <h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION["usuario_nome"]); ?>!</h2>
  <p><a href="php/logout.php">Sair</a></p>
</body>
</html>

