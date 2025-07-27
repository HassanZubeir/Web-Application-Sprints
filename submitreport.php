<?php include "database.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submit Discrimination Report EquiSafe</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <header>
    <h1>EquiSafe</h1>
    <p>Your Safety, Our Priority</p>
  </header>

<nav>
      <a href="home.php">Home</a>
      <a href="reports.php">Submitted reports</a>
      <a href="logout.php">Logout</a>
  </nav>

  <div class="container">
    <h2>Submit a Discrimination Report</h2>
    <p>Please fill in the form below to report any discriminatory behavior you've experienced or witnessed. All submissions will be treated with confidentiality and seriousness.</p>

    <form action="submitreport_details.php" method="POST">
      <label for="fullname">Your Name (Optional)</label>
      <input type="text" id="fullname" name="fullname" placeholder="Leave blank to remain anonymous">
      
      <label for="email_address">Email Address</label>
      <input type="text" id="email_address" name="email_address"placeholder="Enter Email Address" required>

      
      <label for="Department">Department</label>
      <input type="text" id="Department" name="Department" required>
      
      <label for="Offender Name">Offender Name</label>
      <input type="text" id="Offender_name" name="Offender_name" required>

      <label for="Discrimination type">Discrimination type</label>
      <input type="text" id="Discrimination_type" name="Discrimination_type" placeholder="Enter Discrimination type">

      <label for="Date occurred">Date occurred</label>
      <input type="date" id="Date_occurred" name="Date_occurred" placeholder="DD/MM/YYYY">

      <label for="CommunicationMode">Preferred Mode of Communication:</label>
      <select id="Communication_mode" name="Communication_mode" required>
      <option value="">-- Select an option --</option>
      <option value="email">Email</option>
      <option value="in_person">In Person</option>
      <option value="mobile">Mobile</option>
</select>

      <label for="description">Describe the incident</label>
      <textarea id="Description_incident" name="Description_incident" rows="6" required placeholder="Include details like what happened, who was involved, and where/when it occurred."></textarea>

      <input type="submit" name = "submitreport_details" value="Submit Report">
    </form>
  </div>

  <footer>
    <p>&copy; 2025 EquiSafe. All rights reserved.</p>
  </footer>

</body>
</html>
