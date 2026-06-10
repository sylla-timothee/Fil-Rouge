<?php
function jsonResponse(int $code, array $data): void
{
    http_response_code($code);
    echo json_encode($data);
    exit;
}
?>