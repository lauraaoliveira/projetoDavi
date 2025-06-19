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

      $sql = "SELECT qtd_oleo, solicitado, qtd_para_coletar FROM usuarios WHERE id_usuario = :id";

      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':id', $id_usuario);
      $stmt->execute();
      $dados = $stmt->fetch(PDO::FETCH_ASSOC);

      $qtd_oleo = $dados['qtd_oleo'];
      $solicitado = $dados['solicitado'];
      $qtd_para_coletar = $dados['qtd_para_coletar'];
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
  
  <p>Quantidade total de óleo: <?php echo $qtd_oleo; ?> <?php echo $qtd_oleo == 1? "garrafa" : "garrafas"?></p>


  <h3><?php if($solicitado) echo "Você possui uma solicitação pendente"?></h3>
  <!-- adicionar óleo -->
  <form action="adicionar_oleo.php" method="post">
    <p><input type="submit" value="+1 oleo" <?php if($solicitado) echo 'disabled'; ?> ></p>
  </form>

  
  <!-- =========== MODAL PARA SOLICITAR A COLETA ================= -->
  <button class="btn-open-modal" data-modal="modal-4" 
  <?php if($solicitado || $qtd_oleo == 0  ) echo 'disabled'; ?>
  >
  <?php echo !$solicitado ? 'Solicitar coleta' : 'Coleta solicitada'; ?>
</button>

<dialog id="modal-4">
  
  <h2>Modal para solicitar a coleta</h1>
  <button class="btn-close-modal" data-modal="modal-4">X</button>
  
  <!-- =========== FORMULÁRIO PARA INFORMAR QUANTO SERÁ COLETADO ================= -->
  <form action="solicitar_coleta.php" method="post">
    <h2> Você irá solicitar a coleta para <?php echo $qtd_oleo?> <?php echo $qtd_oleo == 1? "garrafa" : "garrafas"?></h2>
    <p>
      <input type="submit" value="confirmar">
    </p>
  </form>
    <button class="btn-close-modal" data-modal="modal-4">Cancelar</button>
    
  </dialog>
  

  <!-- excluir conta -->
  <form action="../excluir_conta.php" method="post">
    <p><input type="submit" value="Excluir conta"></p>
  </form>
  <p><a href="../logout.php">Sair</a></p>

  <script src="../../js/modal.js"></script>
</body>
</html>
