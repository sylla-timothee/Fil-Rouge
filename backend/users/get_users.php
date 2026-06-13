<?php

include "../config/connection.php";
require_once "../services/JWTService.php";

$jwt = new JWTService();

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405); // Method Not Allowed
    exit;
}

$headers = getallheaders();
$authorization = $headers['Authorization'] ?? $headers['authorization'] ?? '';

if (preg_match('/Bearer\s(\S+)/', $authorization, $matches)) {
    $token_recu = $matches[1];
} else {
    http_response_code(401);
    echo json_encode(["error" => "Token manquant ou mal formaté"]);
    exit;
}

$payload = $jwt->verify($token_recu);

if (!$payload || $payload['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["error" => "Accès refusé : Droits insuffisants"]);
    exit;
}

$sql = "SELECT id, username, email, admin FROM users";
$result = $connection->query($sql);

header('Content-Type: application/json');

if ($result && $result->num_rows > 0) {
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users);
} else {
    echo json_encode([]);
}

?>