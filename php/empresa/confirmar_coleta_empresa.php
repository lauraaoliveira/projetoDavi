<?php
session_start();
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] != 'empresa') {
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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_coleta'])) {
        $id_coleta = $_POST['id_coleta'];

        $sql = "UPDATE coletas SET confirmacao_empresa = 1 WHERE id_coleta = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_coleta);
        $stmt->execute();

        $sql = "SELECT confirmacao_usuario FROM coletas WHERE id_coleta = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_coleta);
        $stmt->execute();
        $confirmacao_usuario = $stmt->fetchColumn();

        if ($confirmacao_usuario) {
            $sql = "UPDATE coletas SET status = 'finalizada' WHERE id_coleta = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id_coleta);
            $stmt->execute();
            
        }

        header("Location: painel_empresa.php");
        exit;
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
