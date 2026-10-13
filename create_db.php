<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
    $pdo->exec('CREATE DATABASE IF NOT EXISTS cse703073_nhom14_dulich CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    echo "=== BASE DE DATOS CREADA CON EXITO ===\n";
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
