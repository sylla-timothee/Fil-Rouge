<?php
include "../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") exit;

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

$stmt->execute();

echo json_encode(["success" => true, "id" => $stmt->insert_id]);