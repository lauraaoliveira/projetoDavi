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

      $sql = "SELECT c.*, u.nome, u.email, u.logradouro_usuario
              FROM coletas c
              JOIN usuarios u ON c.id_usuario = u.id_usuario
              WHERE c.status = 'pendente'";

      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $coletasPendentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
  <button class="btn-open-modal" data-modal="modal-6">Coletas solicitadas</button>

  <dialog id="modal-6">
    <?php if (count($coletasPendentes) > 0): ?>
      <ul>
        <?php foreach ($coletasPendentes as $coleta): ?>
          <li>
            <strong>Nome:</strong> <?php echo $coleta['nome']; ?><br>
            <strong>Email:</strong> <?php echo $coleta['email']; ?><br>
            <strong>Endereço:</strong> <?php echo $coleta['logradouro_usuario']; ?><br>
            <strong>Quantidade:</strong> <?php echo $coleta['quantidade']; ?> garrafas<br>
            <form action="aceitar_coleta.php" method="post">
              <input type="hidden" name="id_coleta" value="<?php echo $coleta['id_coleta']; ?>">
              <input type="submit" value="Aceitar Coleta">
            </form>
            <hr>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
        <p>Nenhuma coleta pendente no momento.</p>
    <?php endif; ?>
  </dialog>

  

  <form action="../excluir_conta.php" method="post">
    <p><input type="submit" value="Excluir conta"></p>
  </form>
  
  <p><a href="../logout.php">Sair</a></p>

  <script src="../../js/modal.js"></script>
</body>
</html>
