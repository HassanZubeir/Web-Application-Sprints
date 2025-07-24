<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "database.php";
session_start();

if (isset($_POST["signup_details"])) {
    $first_name = htmlspecialchars(trim($_POST["first_name"]));
    $Last_name = htmlspecialchars(trim($_POST["Last_name"]));
    $email_address = htmlspecialchars(trim($_POST["email_address"]));
    $Department = htmlspecialchars(trim($_POST["Department"]));
    $Pass = htmlspecialchars(trim($_POST["Pass"]));

    // Hash the password
    $hashed_pass = password_hash($Pass, PASSWORD_DEFAULT);

    try {
        // Use prepared statement with PDO
        $stmt = $pdo->prepare("INSERT INTO user (first_name, Last_name, email_address, Department, Pass) VALUES (:first_name, :Last_name, :email, :department, :pass)");

        $stmt->execute([
            ':first_name' => $first_name,
            ':Last_name' => $Last_name,
            ':email' => $email_address,
            ':department' => $Department,
            ':pass' => $hashed_pass
        ]);

        $_SESSION['email_address'] = $email_address;
        header("Location: Login.php");
        exit();
    } catch (PDOException $e) {
        echo "❌ Error saving user: " . $e->getMessage();
    }
}
?>
