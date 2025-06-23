<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'usuario') {
    header("Location: ../../index.html");
    exit;
}

$host = "localhost";
$database = "projetooleo";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id_usuario = $_SESSION['id'];
    
    //verificar se o usuario tem uma coleta pendente ou sem finalizar
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM coletas WHERE id_usuario = :id AND status IN ('pendente','aceita')");
    $stmt->bindParam(':id', $id_usuario);
    $stmt->execute();
    
    if($stmt->fetchColumn()>0){
        echo "Você tem uma solicitação pendente";
        exit;
    }
    // pega a quantidade de oleo do usuario
    $stmt = $pdo->prepare("SELECT qtd_oleo FROM usuarios WHERE id_usuario = :id");
    $stmt->bindParam(':id', $id_usuario);
    $stmt->execute();
    $qtd = $stmt->fetchColumn();

    // garante q nao tem como solicitar coleta se a quantidade de oleo for 0
    if ($qtd <= 0) {
        echo "Você não tem óleo suficiente para solicitar coleta.";
        exit;
    }

    // atualiza os campos de usuario (solicitado e quantiade de oleo)
    $stmt = $pdo->prepare("UPDATE usuarios SET solicitado = 1, qtd_oleo = 0 WHERE id_usuario = :id");
    $stmt->bindParam(':id', $id_usuario);
    $stmt->execute();

    // cria uma nova coleta na tabela coletas
    $stmt = $pdo ->prepare("INSERT INTO coletas (id_usuario, quantidade,status) VALUES (:id_usuario, :quantidade, 'pendente')");
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':quantidade', $qtd);
    $stmt->execute();


    header("Location: ../../index.php");
    exit;

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
