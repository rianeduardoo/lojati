<?php

require "config.php";

$rota = $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "clientes" : "teste");

function teste() {
    echo "API respondendo com sucesso!";
}

function readClientes($con){
    header("Content-Type: application/json; charset=utf-8");
    $stmt = $con->query("SELECT * FROM clientes");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function createClientes($con){
   $nome = $_POST["nome"] ?? "";
   $email = $_POST["email"] ?? "";
   $telefone = $_POST["telefone"] ?? "";
   $endereco = $_POST["endereco"] ?? "";

   try {
        $stmt = $con->prepare("INSERT INTO clientes (nome, email, telefone, endereco) VALUES (?,?,?,?)");
        $stmt->execute([$nome, $email, $telefone, $endereco]);
        header("Location: ../front/index.html");
   }catch(PDOException $e) {
        header("Location: ../front/erro.html");
}
exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
   createClientes($con);
}elseif ($rota === "clientes") {
   readClientes($con);
} else {
   teste();
}  
?>