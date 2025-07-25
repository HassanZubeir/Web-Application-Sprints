<?php

$host = 'localhost';      
$dbname = 'projects';      
$username = 'root';     
$password = 'student';     
$charset = 'utf8mb4';

// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// Try connecting to the database
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "✅ Connected to the database successfully!";
} catch (PDOException $e) {
   echo "❌ Database connection failed: " . $e->getMessage();
    exit;
}
?>
