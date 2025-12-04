<?php
// configuração do bd
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'financeiro');
define('DB_USER', 'root');
define('DB_PASS', 'mysql');

// conexão com o bd
try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . "; dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERRO na conexão com o banco de dados: " . $e->getMessage());
}
