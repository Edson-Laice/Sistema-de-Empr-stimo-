<?php
// Configurações de conexão com o MySQL
$servername = "localhost"; // Host do banco de dados
$username = "root"; // Nome de usuário do MySQL
$password = ""; // Senha do MySQL
$database = "db_lms2"; // Nome do banco de dados

// Criar uma conexão com o MySQL
$conn2 = new mysqli($servername, $username, $password, $database);

// Verificar se a conexão foi bem-sucedida
if ($conn2->connect_error) {
    die("Falha na conexão com o MySQL: " . $conn2->connect_error);
}
?>