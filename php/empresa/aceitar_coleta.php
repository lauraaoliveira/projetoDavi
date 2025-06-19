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

      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_usuario'])) {
        $id_usuario = $_POST['id_usuario'];

        $sql = "UPDATE usuarios SET solicitado = 0, qtd_para_coletar = 0 WHERE id_usuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_usuario);
        $stmt->execute();

        header("Location: painel_empresa.php");
        exit;
      } 
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
?>