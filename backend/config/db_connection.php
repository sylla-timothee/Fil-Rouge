<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "users";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connexion->connect_error) {
    die("Connection failed" . $conn->connect_error);
}