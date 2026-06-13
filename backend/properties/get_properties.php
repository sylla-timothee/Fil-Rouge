<?php
header('Content-Type: application/json');
include "../config/connection.php";

$properties = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $sql = "
    SELECT p.id, p.title, p.city, p.surface, p.address, p.prix, p.type, p.status,
        img.url AS image_url
    FROM properties p
    LEFT JOIN properties_images img 
        ON img.property_id = p.id 
        AND img.sort_order = (
            SELECT MIN(sort_order) 
            FROM properties_images 
            WHERE property_id = p.id
        )
";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $properties[] = $row;
        }
    }
    
    $connection->close();
}

echo json_encode($properties);
?>