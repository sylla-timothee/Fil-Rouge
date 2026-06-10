<?php
session_start();
include "../config/connection.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(["error" => "Utilisateur non connecté"]);
    exit();
}

$email = $_SESSION['user']['email'];

$stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user) {
    echo json_encode([
        "success"   => true,
        "firstName" => $user['first_name'], 
        "email"     => $user['email']
    ]);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Utilisateur introuvable"]); 
}

$connection->close();