<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "filrouge";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connexion->connect_error) {
    die("Connection failed" . $conn->connect_error);
}