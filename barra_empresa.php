<?php
// Não precisa de session_start, já foi feito no index

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'empresa') {
    // Se por acaso alguém tentar acessar sem estar logado como empresa
    header("Location: index.php");
    exit;
}

try {
    // Buscar coletas pendentes (sem empresa ainda)
    $sql = "SELECT c.*, u.nome, u.email, u.logradouro_usuario
            FROM coletas c
            JOIN usuarios u ON c.id_usuario = u.id_usuario
            WHERE c.status = 'pendente'";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $coletasPendentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Buscar coletas já aceitas por esta empresa
    $id_empresa = $_SESSION['id'];

    $sql = "SELECT c.*, u.nome, u.email, u.logradouro_usuario
            FROM coletas c
            JOIN usuarios u ON c.id_usuario = u.id_usuario
            WHERE c.status = 'aceita' AND c.id_empresa = :id_empresa";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_empresa', $id_empresa);
    $stmt->execute();
    $coletasAceitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>


<div class="residencia">
    <div class="residencia-content container">
      <button class="btn-open-modal botao" data-modal="modal-6">Coletas solicitadas</button>
      <button class="btn-open-modal botao" data-modal="modal-7">Coletas aceitas</button>
  </div>
</div>


<dialog id="modal-7">
    <?php if (count($coletasAceitas) > 0): ?>
      <ul>
        <?php foreach ($coletasAceitas as $coleta): ?>
          <li>
            <strong>Nome:</strong> <?php echo $coleta['nome']; ?><br>
            <strong>Email:</strong> <?php echo $coleta['email']; ?><br>
            <strong>Endereço:</strong> <?php echo $coleta['logradouro_usuario']; ?><br>
            <strong>Quantidade:</strong> <?php echo $coleta['quantidade']; ?> garrafas<br>

            <?php if (!$coleta['confirmacao_empresa']): ?>
              <form action="php/empresa/confirmar_coleta_empresa.php" method="post">
                <input type="hidden" name="id_coleta" value="<?php echo $coleta['id_coleta']; ?>">
                <button type="submit">Confirmar coleta</button>
              </form>
              
            <?php else: ?>
              <p>Aguardando confirmação do usuário</p>
            <?php endif; ?>

            <hr>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>Nenhuma coleta aceita por você ainda.</p>
    <?php endif; ?>
  </dialog>

<!-- ===================MODAIS=================== -->

  <dialog id="modal-6 ">
    <?php if (count($coletasPendentes) > 0): ?>
      <ul>
        <?php foreach ($coletasPendentes as $coleta): ?>
          <li>
            <strong>Nome:</strong> <?php echo $coleta['nome']; ?><br>
            <strong>Email:</strong> <?php echo $coleta['email']; ?><br>
            <strong>Endereço:</strong> <?php echo $coleta['logradouro_usuario']; ?><br>
            <strong>Quantidade:</strong> <?php echo $coleta['quantidade']; ?> garrafas<br>
            <form action="php/empresa/aceitar_coleta.php" method="post">
              <input type="hidden" name="id_coleta" value="<?php echo $coleta['id_coleta']; ?>">
              <input type="submit" value="Aceitar solicitação">
            </form>
            <hr>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
        <p>Nenhuma coleta pendente no momento.</p>
    <?php endif; ?>
  </dialog>

