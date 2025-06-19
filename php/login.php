<?php
session_start();

$host = "localhost";
$database = "projetooleo";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $tipo = $_POST['tipo'];

        if ($tipo == 'usuario') {
            $sql = "SELECT * FROM usuario WHERE email = :email AND senha = :senha";
        } elseif ($tipo == 'empresa') {
            $sql = "SELECT * FROM empresa WHERE email_empresa = :email AND senha = :senha";
        } else {
            echo "Tipo de login inválido!";
            exit;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($tipo == 'usuario') {
                $_SESSION['tipo'] = 'usuario';
                $_SESSION['id'] = $dados['id_usuario'];
                $_SESSION['nome'] = $dados['nome'];
                header("Location: usuario/painel_usuario.php");
                exit;
            } elseif ($tipo == 'empresa') {
                $_SESSION['tipo'] = 'empresa';
                $_SESSION['id'] = $dados['id_empresa'];
                $_SESSION['nome'] = $dados['nome_fantasia'];
                header("Location: empresa/painel_empresa.php");
                exit;
            }
        } else {
            echo "Email ou senha incorretos!";
        }
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
