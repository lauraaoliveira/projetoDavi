<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $db = "projetooleo";
    $user = "root";
    $pass = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $email = $_POST["email"];
        $senha = $_POST["senha"];

        $sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();

        // $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // if ($usuario && password_verify($senha, $usuario["senha"])) {
        //     $_SESSION["usuario_id"] = $usuario["id"];
        //     $_SESSION["usuario_nome"] = $usuario["nome"];
        //     echo "Login realizado com sucesso!";
        //     //header("Location: ../painel_usuario.php"); //em tese deveria ir pra painel por uma questão de segurança, mas está dando erro direcionando para outra página
        //     exit;
        // } else {
        //     echo "Email ou senha inválidos.";
        // }


        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC); 
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nome"] = $usuario["nome"];
            echo "Login realizado com sucesso!";
            header("Location: painel_usuario.php");
            exit;
        } else {
            echo "Email ou senha inválidos!";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>
