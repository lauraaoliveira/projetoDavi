<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $host = "localhost";
    $db = "projetooleo";
    $user = "root";
    $pass = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $qtd_oleo = 0;
        $solicitado = 0;

        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $logradouroUsuario = $_POST['logradouro_usuario'];


        $sql = "INSERT INTO usuarios (nome, email, senha, logradouro_usuario, qtd_oleo, solicitado) VALUES (:nome, :email, :senha, :logradouro_usuario, :qtd_oleo, :solicitado)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":logradouro_usuario", $logradouroUsuario);
        $stmt->bindParam(":qtd_oleo", $qtd_oleo);
        $stmt->bindParam(":solicitado", $solicitado);

        $stmt->execute();
        echo "Usuário cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>
