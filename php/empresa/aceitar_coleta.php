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
        $id_empresa = $_SESSION['id'];

        $sql = "UPDATE coletas SET status = 'aceita', id_empresa = :id_empresa WHERE id_coleta = :id_coleta";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_empresa', $id_empresa);
        $stmt->bindParam(':id_coleta', $id_coleta);
        $stmt->execute();

        header("Location: painel_empresa.php");
        exit;
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>