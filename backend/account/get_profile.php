<?php
include "../config/connection.php";
include "../services/JWTService.php"; 

header('Content-Type: application/json');

// 1. Récupérer les en-têtes de la requête
$headers = getallheaders();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

// 2. Vérifier si le token Bearer est présent
if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    http_response_code(401);
    echo json_encode(["error" => "Utilisateur non connecté (Token manquant)"]);
    exit();
}

$token = $matches[1];

$jwtService = new JWTService();
$payload = $jwtService->verify($token);

if (!$payload || !isset($payload['email'])) {
    http_response_code(401);
    echo json_encode(["error" => "Session expirée ou invalide"]);
    exit();
}

$email = $payload['email'];

$stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user) {
    echo json_encode([
        "success"    => true,
        "first_name" => $user['first_name'], 
        "email"      => $user['email']
    ]);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Utilisateur introuvable"]); 
}

$connection->close();