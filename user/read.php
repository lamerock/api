<?php
header("Content-Type: application/json");
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT id, name, email, created_at FROM users";
$stmt = $db->prepare($query);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($users);
?>
