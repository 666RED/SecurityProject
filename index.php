<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['act']) && $_POST['act'] == 'login') {
        $student_email = $_POST['student_student_email'];
        $password = $_POST['student_password'];

        // User validation
        $sql = "SELECT * FROM student WHERE student_student_email='$student_email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
            if (password_verify($password, $student['student_password'])) {
                session_regenerate_id(true); // Regenerate session ID
                $_SESSION['student_matric_number'] = $student['student_matric_number'];
                $_SESSION['student_student_email'] = $student_email;
                $_SESSION['last_activity'] = time(); // Update last activity time stamp
                $_SESSION['expire_time'] = 1800; // Session expires after 30 minutes of inactivity
                header('Location: homepage.php');
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
    } elseif (isset($_POST['act']) && $_POST['act'] == 'reset') {
        $email = $_POST['student_student_email'];
        $phone = $_POST['student_phone_number'];
        $new_password = $_POST['new_password'];

        // Check if email and phone number match
        $sql = "SELECT * FROM student WHERE student_student_email='$email' AND student_phone_number='$phone'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Update the password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql_update = "UPDATE student SET student_password='$hashed_password' WHERE student_student_email='$email' AND student_phone_number='$phone'";
            if ($conn->query($sql_update) === TRUE) {
                $success = "Successfully Reset";
                echo "<script>document.getElementById('idSuccessReset').style.display='block';</script>";
            } else {
                $error = "Error updating password.";
            }
        } else {
            $error = "Email or phone number not found.";
            echo "<script>document.getElementById('idReset').style.display='block';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Management System</title>
  <link rel="stylesheet" href="w3.css">
  <style>
  body,
  html {
    height: 100%;
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    overflow: hidden;
    /* Prevent scrolling */
  }

  .bg {
    background: url('image/background.png') no-repeat center center fixed;
    background-size: cover;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .form-container {
    width: 90%;
    max-width: 600px;
    padding: 25px;
    height: 500px;
    background-color: #f7f7f7;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    overflow-y: auto;
    /* Allow scrolling inside the container if needed */
  }

  .form-container h2 {
    margin-bottom: 10px;
    font-size: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    /* Use Segoe UI font */
    margin-bottom: 20px;
    /* Increase bottom margin */
    color: #0073aa;
    /* Adjust font color */
  }

  .form-container input[type="text"],
  .form-container input[type="email"],
  .form-container input[type="password"],
  .form-container input[type="date"],
  .form-container select {
    width: 100%;
    padding: 8px;
    margin: 4px 0 16px 0;
    display: inline-block;
    border: none;
    background: #ebeff1;
  }

  .form-container input[type="text"]:focus,
  .form-container input[type="email"]:focus,
  .form-container input[type="password"]:focus,
  .form-container input[type="date"]:focus,
  .form-container select:focus {
    background-color: #ddd;
    outline: none;
  }

  .form-container button {
    background-color: #0073aa;
    color: white;
    padding: 12px 15px;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
  }

  .form-container button:hover {
    opacity: 1;
  }

  .form-container label {
    margin-bottom: 4px;
    display: block;
    text-align: left;
  }

  .pill-nav {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
  }

  .pill-nav a {
    padding: 10px 20px;
    margin: 0 10px;
    border-radius: 20px;
    border: 1px solid #3780a3;
    color: #3780a3;
    text-decoration: none;
    cursor: pointer;
  }

  .pill-nav a.active,
  .pill-nav a:hover {
    background-color: #3780a3;
    color: white;
  }
  </style>
</head>

<body>

  <div class="bg">
    <div class="form-container">
      <div class="pill-nav">
        <a href="index.php" class="active">Login</a>
        <a href="register.php">Sign Up</a>
      </div>
      <h2>Already Have Account, Log In Here !</h2>
      <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
      <form action="" method="post">
        <label for="student_student_email"><b>Email</b></label>
        <input type="email" id="student_student_email" name="student_student_email"
          placeholder="Enter your student email" required>

        <label for="student_password"><b>Password</b></label>
        <input type="password" id="student_password" name="student_password" placeholder="Enter your password" required>

        <input name="act" type="hidden" value="login">
        <button type="submit">Log in</button>

        <label>
          <input type="checkbox" checked="checked" name="remember"> Remember me
        </label>
      </form>
      <a href="#" onclick="document.getElementById('idReset').style.display='block'"
        class="w3-bar-item w3-button">Forgot Password?</a>
    </div>
  </div>

  <!-- Forgot Password Modal -->
  <div id="idReset" class="w3-modal">
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container w3-center">
        <span onclick="document.getElementById('idReset').style.display='none'"
          class="w3-button w3-display-topright w3-circle">&times;</span>
        <h2>Reset Password</h2>
      </header>
      <hr>
      <div class="w3-container w3-padding w3-margin">
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="" method="post">
          <div class="w3-section">
            <label>Mobile Phone *</label>
            <input class="w3-input w3-border w3-round" type="tel" name="student_phone_number" required>
          </div>
          <div class="w3-section">
            <label>Email *</label>
            <input class="w3-input w3-border w3-round" type="email" name="student_student_email" required>
          </div>
          <div class="w3-section">
            <label>New Password *</label>
            <input class="w3-input w3-border w3-round" type="password" name="new_password" maxlength="20" required>
          </div>
          <input name="act" type="hidden" value="reset">
          <button type="submit"
            class="w3-button w3-block w3-padding-large w3-blue w3-wide w3-margin-bottom w3-round">Reset
            Password</button>
        </form>
        <div class="w3-center">
          Already registered? <a href="#" onclick="document.getElementById('idReset').style.display='none';"
            class="w3-text-blue">LOGIN HERE</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Reset Modal -->
  <div id="idSuccessReset" class="w3-modal" style="z-index:10;">
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container">
        <span onclick="document.getElementById('idSuccessReset').style.display='none'"
          class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>
      <div class="w3-container w3-padding">
        <form action="" method="post">
          <div class="w3-padding"></div>
          <b class="w3-large">Success</b>
          <hr class="w3-clear">
          Successfully Reset.
          <div class="w3-padding-16"></div>
          <a onclick="document.getElementById('idSuccessReset').style.display='none'; document.getElementById('idReset').style.display='none';"
            class="w3-button w3-block w3-padding-large w3-green w3-wide w3-margin-bottom w3-round">SIGN IN</a>
        </form>
      </div>
    </div>
  </div>

</body>

</html>