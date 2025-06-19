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

    $sql = "UPDATE usuarios SET qtd_oleo = qtd_oleo + 1 WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario);
    $stmt->execute();

    header("Location: painel_usuario.php");
    exit;

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
