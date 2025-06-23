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

    $sql = "SELECT * FROM coletas WHERE id_usuario = :id_usuario AND status = 'aceita' ORDER BY id_coleta DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();

    $coleta = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($coleta) {
        
        $sql = "UPDATE coletas SET confirmacao_usuario = 1 WHERE id_coleta = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $coleta['id_coleta']);
        $stmt->execute();

        $sql = "UPDATE usuarios SET solicitado = 0 WHERE id_usuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_usuario);
        $stmt->execute();

        if ($coleta['confirmacao_empresa']) {
            $sql = "UPDATE coletas SET status = 'finalizada' WHERE id_coleta = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $coleta['id_coleta']);
            $stmt->execute();
        }
    }

    header("Location: ../../index.php");
    exit;

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
