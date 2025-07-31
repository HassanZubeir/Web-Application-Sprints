<?php
ob_start(); // Ensure header() works
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "database.php";
session_start();

if (isset($_POST["submitreport_details"])) {

    $fullname = htmlspecialchars(trim($_POST["fullname"]));
    $email_address = htmlspecialchars(trim($_POST["email_address"]));
    $Department = htmlspecialchars(trim($_POST["Department"]));
    $Offender_name = htmlspecialchars(trim($_POST["Offender_name"]));
    $Discrimination_type = htmlspecialchars(trim($_POST["Discrimination_type"]));
    $Date_occurred = htmlspecialchars(trim($_POST["Date_occurred"]));
    $Communication_mode = htmlspecialchars(trim($_POST["Communication_mode"]));
    $Description_incident = htmlspecialchars(trim($_POST["Description_incident"]));

    // Convert communication mode to match ENUM values in DB
    switch (strtolower($Communication_mode)) {
        case 'email':
            $Communication_mode = 'Email';
            break;
        case 'in_person':
            $Communication_mode = 'In Person';
            break;
        case 'mobile':
            $Communication_mode = 'Mobile';
            break;
        default:
            $Communication_mode = 'Email'; // default fallback
    }

    // If name is empty, make it anonymous
    if (empty($fullname)) {
        $fullname = "Anonymous";
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO DiscriminationReport 
            (fullname, email_address, Department, Offender_name, Discrimination_type, Date_occurred, Communication_mode, Description_incident) 
            VALUES 
            (:fullname, :email, :department, :offender, :type, :date_occurred, :mode, :description)");

        $stmt->execute([
            ':fullname' => $fullname,
            ':email' => $email_address,
            ':department' => $Department,
            ':offender' => $Offender_name,
            ':type' => $Discrimination_type,
            ':date_occurred' => $Date_occurred,
            ':mode' => $Communication_mode,
            ':description' => $Description_incident
        ]);

        $_SESSION['email_address'] = $email_address;
        header("Location: reports.php");
        exit();

    } catch (PDOException $e) {
        echo "<p style='color:red;'>❌ Error saving report: " . $e->getMessage() . "</p>";
    }
}
ob_end_flush();
?>
