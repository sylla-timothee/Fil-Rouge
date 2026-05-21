<?php

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$password = password_hash($data['password'], PASSWORD_DEFAULT);

if (!$name || !$email || !$password) {
    jsonResponse(400, ["error" => "Missing email or password"]);
}

$stmt = $mysqli->prepare("SELECT * FROM USERS WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$checkEmail = $stmt->get_result();

$stmt = $mysqli->prepare("SELECT IdUser FROM USERS WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$checkUsername = $stmt->get_result();

if ($checkEmail->num_rows > 0) {
        jsonResponse(409, ["error" => "Email already taken"]);
    }

    if ($checkName->num_rows > 0) {
        jsonResponse(409, ["error" => "Name already taken"]);
    }

    $stmt = $mysqli->prepare("INSERT INTO USERS (name, email, password) VALUES (?,?,?)");
    $stmt->bind_param("sss", $name, $email, $password);
    $stmt->execute();

    $_SESSION['IdUser'] = $mysqli->insert_id;

    jsonResponse(201, [
        "success" => true,
        "IdUser" => $_SESSION['IdUser']
    ]);