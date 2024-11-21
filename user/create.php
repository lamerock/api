<?php
header("Content-Type: application/json");
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->email) && !empty($data->password)) {
    $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":name", $data->name);
    $stmt->bindParam(":email", $data->email);
    $stmt->bindParam(":password", password_hash($data->password, PASSWORD_DEFAULT));

    if ($stmt->execute()) {
        echo json_encode(["message" => "User created successfully."]);
    } else {
        echo json_encode(["message" => "Failed to create user."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
