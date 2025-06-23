<?php

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'usuario') {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION['id'];

try {
    $sql = "SELECT qtd_oleo, solicitado FROM usuarios WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario);
    $stmt->execute();
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    $qtd_oleo = $dados['qtd_oleo'];
    $solicitado = $dados['solicitado'];

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

  <div class="residencia">
    <div class="residencia-content container">

    <?php if($status_coleta == 'aceita'): ?>
      <div>
        <img src="img/coleta.svg" alt="Coleta">
        <h5><?php echo $empresa_responsavel; ?> está a caminho para coleta de óleo em sua residência.</h5>
        <a href="#" class="botao confirma">Confirmar coleta</a>
      </div>
    <?php elseif($status_coleta == 'pendente'): ?>
      <h5>Você possui uma solicitação pendente, aguarde uma empresa aceitar</h5>
    <?php else: ?>
      <h5>Você não possui coletas solicitadas.</h5>
    <?php endif; ?>

    <h5>Você possui <?php echo $qtd_oleo; ?> litros de óleo cadastrados.</h5>
    <button class="btn-open-modal botao" data-modal="modal-5">Cadastrar óleo</button>
    <button class="btn-open-modal botao" data-modal="modal-4" 
      <?php if($solicitado || $qtd_oleo == 0  ) echo 'disabled'; ?>
      >
      <?php echo !$solicitado ? 'Solicitar coleta' : 'Coleta solicitada'; ?>
    </button>
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

    <form action="php/usuario/confirmar_coleta_usuario.php" method="post">
        <?php if ($id_coleta): ?>
            <input type="hidden" name="id_coleta" value="<?php echo $id_coleta; ?>">
        <?php endif; ?>
        <button type="submit" <?php if ($botaoDisabled) echo "disabled"; ?>>
            <?php echo $botaoTexto; ?>
        </button>
    </form>

  </div>
</div>




<!-- ========================MODAIS DO USUARIO======================== -->

<!-- CADASTRAR OLEO -->
<dialog id="modal-5">
    <p>Você tem: <?php echo $qtd_oleo; ?><?php echo $qtd_oleo== 1? " garrafa de óleo": " garrafas de óleo"?></p>
    
    <form action="php/usuario/adicionar_oleo.php" method="post">

      <button type="button" onclick="alterarQuantidade(-1)">- 1</button>
      <p>Adicionar <span id="contador">1</span> garrafas</p>
      <button type="button" onclick="alterarQuantidade(1)">+ 1</button>

      <input type="hidden" name="quantidade" id="quantidade" value="1">

      <p><input type="submit" value="Confirmar"></p>
      <button class="btn-close-modal" data-modal="modal-5">Cancelar</button>
    </form>
  </dialog>

  <!-- SOLICITAR COLETA -->
  <dialog id="modal-4">
  
  <h2>Modal para solicitar a coleta</h1>
  <button class="btn-close-modal" data-modal="modal-4">X</button>

  <form action="php/usuario/solicitar_coleta.php" method="post">
    <h2> Você irá solicitar a coleta para <?php echo $qtd_oleo?> <?php echo $qtd_oleo == 1? "garrafa" : "garrafas"?></h2>
    <p>
      <input type="submit" value="confirmar">
    </p>
  </form>
    <button class="btn-close-modal" data-modal="modal-4">Cancelar</button>
    
  </dialog>
<script src="js/modal.js"></script>
<script src="js/contadorOleo.js"></script>
