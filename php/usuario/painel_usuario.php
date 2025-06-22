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

      $nome_empresa_aceitou = "";

      $sql = "SELECT c.id_coleta, c.status, c.confirmacao_usuario, c.confirmacao_empresa, e.nome_fantasia
        FROM coletas c
        LEFT JOIN empresa e ON c.id_empresa = e.id_empresa
        WHERE c.id_usuario = :id_usuario AND c.status IN ('pendente', 'aceita', 'finalizada')
        ORDER BY c.id_coleta DESC
        LIMIT 1";



      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':id_usuario', $id_usuario);
      $stmt->execute();

      $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

      $id_coleta = null;
      $status_coleta = null;
      $confirmado_usuario = false;
      $confirmado_empresa = false;
      $nome_empresa_aceitou = "";
      if ($resultado) {
          $id_coleta = $resultado['id_coleta'];
          $status_coleta = $resultado['status'];
          $confirmado_usuario = $resultado['confirmacao_usuario'];
          $confirmado_empresa = $resultado['confirmacao_empresa'];
          $nome_empresa_aceitou = $resultado['nome_fantasia'];
      }

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

  <h3>Você tem: <?php echo $qtd_oleo; ?><?php echo $qtd_oleo== 1? " garrafa de óleo": " garrafas de óleo"?></h3>
  
  <h4>
    <?php if ($nome_empresa_aceitou && $solicitado): ?>
      <p>A empresa <strong><?php echo $nome_empresa_aceitou; ?></strong> aceitou sua solicitação de coleta. Aguarde!</p>
    <?php elseif ($solicitado): ?>
      <p>Você possui uma solicitação pendente, aguarde uma empresa aceitar!</p>
    <?php endif; ?>
  </h4>


    <!-- =========== CONTROLE DO BOTÃO DE CONFIRMAÇÃO DE COLETA ================= -->
    <?php
    $botaoDisabled = true;
    $botaoTexto = "Confirmar coleta";

    if ($id_coleta) {
        if ($status_coleta == 'aceita' && !$confirmado_usuario) {
            $botaoDisabled = false;
        } elseif ($status_coleta == 'pendente') {
            $botaoTexto = "Aguardando empresa aceitar...";
        }elseif ($status_coleta=='aceita' && $confirmado_usuario) {
          $botaoTexto = "Aguardando confirmação da empresa";
          $botaoDisabled = true;
        } elseif ($status_coleta == 'finalizada') {
            $botaoTexto = "Coleta já finalizada";
            $botaoDisabled = true;
        }
    } else {
        $botaoTexto = "Nenhuma coleta solicitada";
    }

    ?>

    <form action="confirmar_coleta_usuario.php" method="post">
        <?php if ($id_coleta): ?>
            <input type="hidden" name="id_coleta" value="<?php echo $id_coleta; ?>">
        <?php endif; ?>
        <button type="submit" <?php if ($botaoDisabled) echo "disabled"; ?>>
            <?php echo $botaoTexto; ?>
        </button>
    </form>


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
