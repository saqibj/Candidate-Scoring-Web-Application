<?php
// Error reporting for development
if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Secure session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.use_strict_mode', 1);

session_start();

// Session security
if (!isset($_SESSION['last_regeneration']) || time() - $_SESSION['last_regeneration'] >= 300) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// IP-based session protection
if (!isset($_SESSION['client_ip']) || $_SESSION['client_ip'] !== $_SERVER['REMOTE_ADDR']) {
    session_regenerate_id(true);
    $_SESSION['client_ip'] = $_SERVER['REMOTE_ADDR'];
}

// Database configuration
$config = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'database' => 'candidate_scoring',
    'charset' => 'utf8mb4',
    'options' => [
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT),
        mysqli_set_charset($conn, 'utf8mb4')
    ]
];

try {
    $conn = new mysqli(
        $config['host'],
        $config['user'],
        $config['password'],
        $config['database']
    );
    
    // Set charset
    $conn->set_charset($config['charset']);
    
    // Enable error reporting
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
} catch (mysqli_sql_exception $e) {
    // Log error securely
    error_log("Database connection failed: " . $e->getMessage());
    
    // Show generic error message
    die("A database error occurred. Please try again later.");
}

// Set security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
?>