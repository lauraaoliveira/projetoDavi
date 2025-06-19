<?php
  session_start();
  if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'usuario') {
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

      $id_usuario = $_SESSION['id'];

      $sql = "SELECT qtd_oleo, solicitado FROM usuarios WHERE id_usuario = :id";

      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':id', $id_usuario);
      $stmt->execute();
      $dados = $stmt->fetch(PDO::FETCH_ASSOC);

      $qtd_oleo = $dados['qtd_oleo'];
      $solicitado = $dados['solicitado'];
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
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
  
  <p>Quantidade atual de óleo: <?php echo $qtd_oleo; ?> litros</p>

  <form action="adicionar_oleo.php" method="post">
    <p><input type="submit" value="+1 oleo"></p>
  </form>

  <form action="../excluir_conta.php" method="post">
    <p><input type="submit" value="Excluir conta"></p>
  </form>
  <p><a href="../logout.php">Sair</a></p>

</body>
</html>
