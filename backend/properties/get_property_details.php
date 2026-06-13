<?php
header('Content-Type: application/json');
include "../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET" || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["message" => "ID manquant"]);
    exit;
}

$id = (int) $_GET['id'];

$sql = "
    SELECT 
        p.id, p.title, p.city, p.surface, p.address, p.prix, p.type, p.status,
        img.url        AS image_url,
        a.city         AS agency_city,
        a.address      AS agency_address,
        a.phone        AS agency_phone,
        CONCAT(u.first_name, ' ', u.last_name) AS agent_name
    FROM properties p
    LEFT JOIN properties_images img 
        ON img.property_id = p.id 
        AND img.sort_order = (SELECT MIN(sort_order) FROM properties_images WHERE property_id = p.id)
    LEFT JOIN agencies a ON a.id = p.agency_id
    LEFT JOIN users    u ON u.id = p.agent_id
    WHERE p.id = ?
    LIMIT 1
";

$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["message" => "Propriété introuvable"]);
    exit;
}

echo json_encode($result->fetch_assoc());
$connection->close();
?>