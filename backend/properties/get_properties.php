<?php
header('Content-Type: application/json');
include "../config/connection.php";

$properties = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $sql = "SELECT title, city, surface, address, prix, type, status FROM properties";
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