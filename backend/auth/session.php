<?php
include "../config/connection.php";
include "../services/JWTService.php"; 

header('Content-Type: application/json');

$headers = getallheaders();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    http_response_code(401);
    echo json_encode(["error" => "Non connecté (Token manquant)"]);
    exit();
}

$token = $matches[1];
$jwtService = new JWTService();
$payload = $jwtService->verify($token);

if (!$payload) {
    http_response_code(401);
    echo json_encode(["error" => "Session expirée ou invalide"]);
    exit();
}

echo json_encode([
    'user' => [
        'email' => $payload['email'],
        'role'  => $payload['role']
    ]
]);