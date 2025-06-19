<?php
  session_start();
  if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'empresa') {
      header("Location: ../../index.html");
      exit;
  }
    $host = "localhost";
    $db = "projetooleo";
    $user = "root";
    $pass = "";

    try {
      $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "SELECT * FROM usuarios WHERE solicitado = 1";

      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $usuariosSolicitando = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
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

  <hr>
  <h1>Aqui é a lista de usuários que solicitaram a coleta:</h1>

  <?php if (count($usuariosSolicitando) > 0): ?>
    <ul>
      <?php foreach ($usuariosSolicitando as $usuario): ?>
        <li>
          <strong>Nome:</strong> <?php echo $usuario['nome']; ?><br>
          <strong>Email:</strong> <?php echo $usuario['email']; ?><br>
          <strong>Endereço:</strong> <?php echo $usuario['logradouro_usuario']; ?><br>
          <strong>Quantidade de Óleo para coletar:</strong> <?php echo $usuario['qtd_para_coletar']; ?> <?php echo $usuario['qtd_para_coletar'] == 1? "garrafa" : "garrafas"?>
          <form action="aceitar_coleta.php" method="post">
            <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
            <input type="submit" value="Aceitar Coleta">
          </form>
          <hr>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>Nenhum usuário solicitou coleta ainda.</p>
  <?php endif; ?>

  <form action="../excluir_conta.php" method="post">
    <p><input type="submit" value="Excluir conta"></p>
  </form>
  
  <p><a href="../logout.php">Sair</a></p>

</body>
</html>
