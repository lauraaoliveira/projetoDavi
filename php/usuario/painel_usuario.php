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

      $sql = "SELECT qtd_oleo, solicitado, qtd_para_coletar, empresa_aceitou FROM usuarios WHERE id_usuario = :id";

      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':id', $id_usuario);
      $stmt->execute();
      $dados = $stmt->fetch(PDO::FETCH_ASSOC);

      $qtd_oleo = $dados['qtd_oleo'];
      $solicitado = $dados['solicitado'];
      $qtd_para_coletar = $dados['qtd_para_coletar'];
      $nome_empresa_aceitou = $dados['empresa_aceitou'];
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
  
  <h3><p>Você possui: <?php echo $qtd_oleo; ?><?php echo $qtd_oleo== 1? " garrafa de óleo disponível para coleta": " garrafas de óleo disponíveis para coleta"?> </p></h3>
  <h3><?php if($solicitado) echo "Você possui uma solicitação pendente"?></h3>
  <h4>
    <?php if ($nome_empresa_aceitou): ?>
      <p>A empresa <strong><?php echo $nome_empresa_aceitou; ?></strong> aceitou sua solicitação de coleta. Aguarde!</p>
    <?php endif; ?>
  </h4>


  <!-- =========== MODAL PARA ADICIONAR OLEO ================= -->
  <button class="btn-open-modal" data-modal="modal-5">Cadastrar óleo</button>
  <dialog id="modal-5">
    <p>Você tem: <?php echo $qtd_oleo; ?><?php echo $qtd_oleo== 1? " garrafa de óleo": " garrafas de óleo"?></p>
    
    <form action="adicionar_oleo.php" method="post">

      <button type="button" onclick="alterarQuantidade(-1)">- 1</button>
      <p>Adicionar <span id="contador">1</span> garrafas</p>
      <button type="button" onclick="alterarQuantidade(1)">+ 1</button>

      <input type="hidden" name="quantidade" id="quantidade" value="1">

      <p><input type="submit" value="Confirmar"></p>
      <button class="btn-close-modal" data-modal="modal-5">Cancelar</button>
    </form>
  </dialog>
  

  
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
  <script src="../../js/contadorOleo.js"></script>
</body>
</html>
