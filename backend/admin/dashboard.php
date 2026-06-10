<?php
session_start();
include "../config/connection.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user']))   {
    http_response_code(401);
    echo json_encode(["error" => "Utilisateur non connecté"]);
    exit();
}

$email = $_SESSION['user'];

$sql = "SELECT * FROM users WHERE email = '$email'";
$tsmt = $connection->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    $response = [
        "success" => true,
        "firstName" => $user['firstName'],
        "email" => $user['email']
    ];
} else {
    http_response_code(404);
    $response = ["error" => "Utilisateur introuvable"];
}

echo json_encode($response);

$connection->close();
?>