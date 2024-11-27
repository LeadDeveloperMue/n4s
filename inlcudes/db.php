<?php
// Database configuration
$host = 'localhost';
$dbname = 'n4s'; // Change to your database name
$username = 'root'; // Default username for XAMPP
$password = ''; // Default password for XAMPP (empty string)

try {
    // Create PDO instance with exception handling
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set the default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Handle connection errors
    die("Database connection failed: " . $e->getMessage());
}
?>
