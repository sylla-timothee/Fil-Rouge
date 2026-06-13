<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Non connecté']);
    exit;
}

echo json_encode(['user' => $_SESSION['user']]);