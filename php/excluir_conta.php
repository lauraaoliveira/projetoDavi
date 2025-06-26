<?php
  session_start();
  $tipo = $_SESSION['tipo'];
  $id = $_SESSION['id'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $host = "localhost";
    $db = "projetooleo";
    $user = "root";
    $pass = "";

    try {
      $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      if ($tipo == 'empresa') {
        $sql = "DELETE FROM empresa WHERE id_empresa = :id";    
      }elseif ($tipo == 'usuario'){
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
      }

      $stmt = $pdo->prepare($sql);

      $stmt->bindParam(":id",$id, PDO::PARAM_INT);
      if($stmt->execute()){
        echo "Registro excluído";
        session_unset();
        session_destroy();
        header("Location: ../index.php");
      }

    } catch (PDOException $e) {
      echo "Erro: " . $e->getMessage();
    }
  }
?>