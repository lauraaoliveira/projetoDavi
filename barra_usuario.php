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

  <!-- =========== CONTROLE DO BOTÃO DE CONFIRMAÇÃO DE COLETA ================= -->

<?php
    $botaoDisabled = true;
    $botaoTexto = "Confirmar coleta";

    if ($id_coleta) {
        if ($status_coleta == 'aceita' && !$confirmado_usuario) {
            $botaoDisabled = false;
        }elseif ($status_coleta=='aceita' && $confirmado_usuario) {
          $botaoTexto = "Aguardando confirmação da empresa";
          $botaoDisabled = true;
        } 
      }
    ?>

<div class="residencia">
  <div class="residencia-content container">

    <?php if($status_coleta == 'aceita'): ?>
      <div class="residencia-content-coleta">
        <img src="img/coleta.svg" alt="Coleta">
        <h5><strong><?php echo $nome_empresa_aceitou; ?></strong> <?php echo $confirmado_empresa?  "está aguardando sua confirmação" : "está a caminho para coleta de óleo em sua residência." ?></h5>

        <form action="php/usuario/confirmar_coleta_usuario.php" method="post">
            <?php if ($id_coleta): ?>
              <input type="hidden" name="id_coleta" value="<?php echo $id_coleta; ?>">
            <?php endif; ?>
            <button type="submit" class="botao confirma" <?php if ($botaoDisabled) echo "disabled"; ?>>
              <?php echo $botaoTexto; ?>
            </button>
        </form>

      </div>
    <?php elseif($status_coleta == 'pendente'): ?>
      <h5>Você possui uma solicitação de coleta <strong>pendente</strong>, aguarde uma empresa aceitar.</h5>
    <?php else: ?>
      <h5>Você não possui um solicitação de coleta.</h5>
    <?php endif; ?>

    <h5 class="qtd-oleo">Você possui <?php echo $qtd_oleo; ?> <?php echo $qtd_oleo ==1? "litro de óleo disponível para coleta." : "litros de óleo disponíveis para coleta."?> </h5>
    <button class="btn-open-modal botao" data-modal="modal-5">Cadastrar óleo</button>
     
      <?php if(!$solicitado && $qtd_oleo > 0):?>
        <button class="btn-open-modal botao" data-modal="modal-4">Solicitar coleta</button>
      <?php endif; ?>
  </div>
</div>

<!-- ========================MODAIS DO USUARIO======================== -->

<!-- CADASTRAR OLEO -->
<dialog id="modal-5">
    <h3 class="titulo">Você tem: <?php echo $qtd_oleo; ?><?php echo $qtd_oleo== 1? " garrafa de óleo": " garrafas de óleo"?></h3>
    
    <form action="php/usuario/adicionar_oleo.php" method="post">
      <div class="contador">
        <button type="button" onclick="alterarQuantidade(-1)" class="reduzir">- 1</button>
        <p>Adicionar <span id="contador">1</span> garrafas</p>
        <button type="button" onclick="alterarQuantidade(1)" class="aumentar">+ 1</button>
      </div>

      <input type="hidden" name="quantidade" id="quantidade" value="1">
      <div class="modal-actions">
        <button type="button" data-modal="modal-5" class="btn-close-modal" onclick="resetarQuantidade()">Cancelar</button>
        <p><input type="submit" value="Confirmar"></p>
      </div>

    </form>
  </dialog>

  <!-- SOLICITAR COLETA -->
  <dialog id="modal-4">
  
  <h3 class="titulo">Solicitar coleta</h3>
  <!-- <button class="btn-close-modal" data-modal="modal-4">X</button> -->

  <form action="php/usuario/solicitar_coleta.php" method="post">
    <h4 class="solicita-coleta"> Você confirma a solicitação para coleta de <?php echo $qtd_oleo?> <?php echo $qtd_oleo == 1? "litro de óleo?" : "litros de óleo?"?></h4>
    <div class="modal-actions">
      <button type="button" class="btn-close-modal" data-modal="modal-4">Cancelar</button>
      <p><input type="submit" value="confirmar"></p>
    </div>
  </form>
    
  </dialog>
<script src="js/contadorOleo.js"></script>
