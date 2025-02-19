<?php
// Configure secure session settings
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.gc_maxlifetime', 3600);

session_start();

// Regenerate session ID periodically
if (!isset($_SESSION['last_regeneration']) || time() - $_SESSION['last_regeneration'] >= 300) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

$host = "localhost";
$user = "root";
$password = "";
$database = "candidate_scoring";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>