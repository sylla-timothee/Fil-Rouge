<?php
header('Content-Type: application/json');
session_start();
include "../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;

$data  = json_decode(file_get_contents("php://input"), true);
$email = $data["email"];
$password = $data["password"];

$stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($password, $user["password"])) {
    $_SESSION["user"] = $user;
    echo json_encode(["success" => true, "IdUser" => $user["id"]]);
} else {
    http_response_code(401);
    echo json_encode(["error" => "Email ou mot de passe incorrect"]);
}