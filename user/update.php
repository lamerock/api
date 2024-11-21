<?php
header("Content-Type: application/json");
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && (!empty($data->name) || !empty($data->email) || !empty($data->password))) {
    $query = "UPDATE users SET name = IFNULL(:name, name), email = IFNULL(:email, email), password = IFNULL(:password, password) WHERE id = :id";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":id", $data->id);
    $stmt->bindParam(":name", $data->name);
    $stmt->bindParam(":email", $data->email);
    $stmt->bindParam(":password", $data->password ? password_hash($data->password, PASSWORD_DEFAULT) : null);

    if ($stmt->execute()) {
        echo json_encode(["message" => "User updated successfully."]);
    } else {
        echo json_encode(["message" => "Failed to update user."]);
    }
} else {
    echo json_encode(["message" => "Incomplete data."]);
}
?>
