<?php
include "../config/connection.php";
require_once "../services/JWTService.php";

$jwt = new JWTService();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
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

if (!$payload || !in_array($payload['role'], ['admin', 'agent'])) {
    http_response_code(403);
    echo json_encode(["error" => "Accès refusé : Droits insuffisants"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $connection->prepare(
    "INSERT INTO properties (agency_id, agent_id, title, city, surface, address, prix, type, status)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

$stmt->bind_param("iissisiss",
    $data["agency_id"],
    $data["agent_id"],
    $data["title"],
    $data["city"],
    $data["surface"],
    $data["address"],
    $data["prix"],
    $data["type"],
    $data["status"]
);

if ($stmt->execute()) {
    header('Content-Type: application/json');
    echo json_encode(["success" => true, "id" => $stmt->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Erreur lors de l'insertion"]);
}