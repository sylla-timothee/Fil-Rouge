<?php
header('Content-Type: application/json');
session_start();
include "../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;

$data      = json_decode(file_get_contents("php://input"), true);
$firstName = $data["firstName"];
$lastName  = $data["lastName"];
$email     = $data["email"];
$password  = password_hash($data["password"], PASSWORD_BCRYPT);

// Vérifie si l'email existe déjà
$stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    http_response_code(409);
    echo json_encode(["error" => "Cet email est déjà utilisé."]);
    exit;
}

// Insertion
$stmt = $connection->prepare(
    "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
$stmt->execute();

echo json_encode(["success" => true, "message" => "Compte créé avec succès."]);