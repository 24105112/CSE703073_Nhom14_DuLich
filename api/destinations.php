<?php
require 'db.php';
header('Content-Type: application/json; charset=utf-8');

$stmt = $pdo->query("SELECT * FROM accessible_destinations");
$destinations = $stmt->fetchAll();

echo json_encode([
    "status" => "success",
    "total" => count($destinations),
    "data" => $destinations
]);
?>