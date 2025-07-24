<?php include "database.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>EquiSafe Sign Up</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

  <!-- Website Header -->
  <header>
    
    <h1>EquiSafe Company</h1>
    <p>Your Safety, Our Priority</p>
  </header>

  <!-- Navigation Bar -->
  <nav>
    <div class="topnav-right">
      <a href="Login.php">Log In</a>
    </div>
  </nav>

  <!-- Sign Up Form Section -->
  <section id="signup" class="container">
    <h2>Sign Up</h2>
    <form action="signup_details.php" method="POST" >
      <label for="first_name">First Name</label>
      <input type="text" id="first_name" name="first_name" required />

      <label for="Last_name">Last Name</label>
      <input type="text" id="Last_name" name="Last_name" required />

      <label for="signupEmail">Email</label>
      <input type="email" id="email_address" name="email_address" required />

      <label for="department">Department</label>
      <input type="text" id="Department" name="Department" required>

      <label for="signupPassword">password</label>
      <input type="password" id="Pass" name="Pass" required />

      <input type="submit" name= "signup_details" value="Sign Up" />
    </form>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 EquiSafe. All rights reserved.</p>
  </footer>

</body>
</html>
