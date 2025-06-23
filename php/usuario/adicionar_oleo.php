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
    $quantidadeParaAdicionar = intval($_POST['quantidade']);

    $sql = "UPDATE usuarios SET qtd_oleo = qtd_oleo + :qtd WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario);
    $stmt->bindParam(':qtd', $quantidadeParaAdicionar);
    $stmt->execute();

    header("Location: ../../index.php");
    exit;

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
