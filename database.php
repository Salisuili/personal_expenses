<?php
$host = "localhost";
$username = "resultGrader";
$password = "resultGrader";
$database = "spendwisedb";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>