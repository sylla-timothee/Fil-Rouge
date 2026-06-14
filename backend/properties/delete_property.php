<?php
include "../config/connection.php";
require_once "../services/JWTService.php";

$jwt = new JWTService();

if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    http_response_code(405);
    exit;
}

$headers = getallheaders();
$authorization = $headers['Authorization'] ?? $headers['authorization'] ?? '';

if (preg_match('/Bearer\s(\S+)/', $authorization, $matches)) {
    $token_recu = $matches[1];
} else {
    http_response_code(401);
    echo json_encode(["error" => "Token manquant"]);
    exit;
}

$payload = $jwt->verify($token_recu);

if (!$payload || !in_array($payload['role'], ['admin', 'agent'])) {
    http_response_code(403);
    echo json_encode(["error" => "Accès refusé"]);
    exit;
}

$id_property = $_GET['id'] ?? null;

if (!$id_property) {
    http_response_code(400);
    echo json_encode(["error" => "ID manquant dans l'URL."]);
    exit;
}

$stmt = $connection->prepare("DELETE FROM properties WHERE id = ?");
$stmt->bind_param("i", $id_property);

header('Content-Type: application/json');

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "Propriété supprimée avec succès."]);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(["success" => false, "error" => "Aucune propriété ne possède cet ID."]);
    }
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Erreur lors de la suppression."]);
}
?>