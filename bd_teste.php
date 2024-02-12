<?php
ECHO "Hello World!<br>";

// Configurações do banco de dados
$host = "dockerbd-mysql-1";
$usuario = "tfc";
$senha = "sk78dshi93jh:hs!";
$banco = "FomeZer0";

// Tentar conectar ao banco de dados
$conn = new mysqli($host, $usuario, $senha, $banco,'3306');

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

echo "Conexão bem-sucedida!";

// Fechar a conexão
$conn->close();
?>
