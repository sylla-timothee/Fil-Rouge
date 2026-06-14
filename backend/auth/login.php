<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json');

include "../config/connection.php";

require_once "../services/JWTService.php"; 

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit;
}

$data  = json_decode(file_get_contents("php://input"), true);
$email = $data["email"] ?? '';
$password = $data["password"] ?? '';

$stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($password, $user["password"])) {
    
    $jwt = new JWTService();
    
    // 3. On génère le token avec l'email et le rôle de l'utilisateur
    $token = $jwt->generate($user["email"], $user["role"]);
    
    echo json_encode([
        "success" => true, 
        "token" => $token,
        "IdUser" => $user["id"]
    ]);

} else {
    http_response_code(401);
    echo json_encode(["error" => "Email ou mot de passe incorrect"]);
}