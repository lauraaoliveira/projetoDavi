<?php

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $host = "localhost";
    $database = "projetooleo";
    $user = "root";
    $password = "";

    try{
      $pdo = new PDO("mysql:host=$host; dbname=$database",$user,$password);

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $nomeFantasia = $_POST['nome_fantasia'];
      $logradouroEmpresa = $_POST['logradouro_empresa'];
      $telefone = $_POST['telefone_empresa'];
      $email = $_POST['email_empresa'];
      $senha = $_POST['senha'];

      $queryInsert = "INSERT INTO empresa (nome_fantasia,logradouro_empresa,telefone_empresa,email_empresa,senha) VALUES (:nome_fantasia,:logradouro_empresa,:telefone_empresa,:email_empresa,:senha)";

      $stmt = $pdo->prepare($queryInsert);

      $stmt->bindParam(":nome_fantasia",$nomeFantasia, PDO::PARAM_STR);
      $stmt->bindParam(":logradouro_empresa",$logradouroEmpresa, PDO::PARAM_STR);
      $stmt->bindParam(":telefone_empresa",$telefone, PDO::PARAM_STR);
      $stmt->bindParam(":email_empresa",$email, PDO::PARAM_STR);
      $stmt->bindParam(":senha",$senha, PDO::PARAM_STR);

      $stmt->execute();
      echo "empresa cadastrada";

    }catch(PDOException $e){
      echo "Error:" .$e->getMessage();
    }
  }else{
    echo "Conexão não estabelecida";
  }

?>