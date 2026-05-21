<?php

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!$name || !$email || !$password) {
    jsonResponse(400, ["error" => "Missing email or password"]);
}

$stmt = $mysqli->prepare("SELECT * FROM USERS WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['IdUser'] = $user["IdUser"];
            $_SESSION['role'] = $user['role'];

            jsonResponse(200, [
                "success" => true,
                "IdUser" => $user["IdUser"]
            ]);
        }
    }
    
jsonResponse(401, ["error" => "Incorrect email or password"]);