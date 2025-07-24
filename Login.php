<?php
session_start();
require_once "database.php"; // Your PDO connection file

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        // Match email with the 'user' table
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email_address = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Pass'])) {
            // Login success: create session
            $_SESSION['UserID'] = $user['UserID'] ?? null; // assuming there's a UserID field
            $_SESSION['email_address'] = $user['email_address'];
            $_SESSION['first_name'] = $user['first_name'];

            header("Location: home.php");
            exit();
        } else {
            $error = "❌ Invalid email or password.";
        }
    } catch (PDOException $e) {
        $error = "❌ Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EquiSafe Log In</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <h1>EquiSafe Company</h1>
    <p>Your Safety, Our Priority</p>
</header>

<nav>
  <div class="topnav-right">
    <a href="Signup.php">Sign Up</a>
  </div>
</nav>

<main class="container">
  <section id="login">
    <h2>Log In</h2>

    <?php if (!empty($error)): ?>
      <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" required placeholder="Enter your email">

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required placeholder="Enter your password">

      <input type="submit" value="Login">

      <p>Don't have an account? <a href="Signup.php">Sign Up Here</a></p>
    </form>
  </section>
</main>

<footer>
  <p>&copy; 2025 EquiSafe. All rights reserved.</p>
</footer>

</body>
</html>
