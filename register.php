<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_matric_number = $_POST['student_matric_number'];
    $student_name = $_POST['student_name'];
    $student_password = $_POST['student_password'];
    $confirm_password = $_POST['confirm_password'];
    $student_gender = $_POST['student_gender'];
    $student_student_email = $_POST['student_student_email'];

    // Check if passwords match
    if ($student_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}$/', $student_password)) {
        $error = "Password must be at least 8 characters long and include at least one uppercase letter, one number, and one special character.";
    } else {
        $hashed_password = password_hash($student_password, PASSWORD_DEFAULT); // Hash the password

        // Insert user
        $sql = "INSERT INTO student (student_matric_number, student_name, student_password, student_gender, student_student_email) VALUES ('$student_matric_number', '$student_name', '$hashed_password', '$student_gender', '$student_student_email')";
        if ($conn->query($sql) === TRUE) {
            header('Location: index.php');
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
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
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden; /* Prevent scrolling */
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
            height: 700px;
            background-color: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            overflow-y: auto; /* Allow scrolling inside the container if needed */
        }
        .form-container h2 {
            margin-bottom: 10px;
            font-size: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Use Segoe UI font */
            margin-bottom: 20px; /* Increase bottom margin */
            color: #0073aa; /* Adjust font color */
        }
        .form-container input[type="text"], .form-container input[type="email"], .form-container input[type="password"], .form-container input[type="date"], .form-container select {
            width: 100%;
            padding: 8px;
            margin: 4px 0 16px 0;
            display: inline-block;
            border: none;
            background: #ebeff1;
        }
        .form-container input[type="text"]:focus, .form-container input[type="email"]:focus, .form-container input[type="password"]:focus, .form-container input[type="date"]:focus, .form-container select:focus {
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
        .pill-nav a.active, .pill-nav a:hover {
            background-color: #3780a3;
            color: white;
        }
    </style>
    <script>
        function validateForm() {
            var password = document.getElementById("student_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var error = "";

            // Check if passwords match
            if (password !== confirmPassword) {
                error = "Passwords do not match.";
            } 
            
            // Check password strength
            var regex = /^(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}$/;
            if (!regex.test(password)) {
                error = "Password must be at least 8 characters long and include at least one uppercase letter, one number, and one special character.";
            }

            if (error) {
                document.getElementById("error_message").innerText = error;
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

<div class="bg">
    <div class="form-container">
        <div class="pill-nav">
            <a href="index.php">Login</a>
            <a href="register.php" class="active">Sign Up</a>
        </div>
        <h2>Create Your Account Here !</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <p id="error_message" style="color:red;"></p>
        <form action="" method="post" onsubmit="return validateForm()">
            <label for="student_matric_number"><b>Matric Number</b></label>
            <input type="text" id="student_matric_number" name="student_matric_number" placeholder="Enter your matric number" required>
                
            <label for="student_name"><b>Name</b></label>
            <input type="text" id="student_name" name="student_name" placeholder="Enter your name" required>
                
            <label for="student_password"><b>Password</b></label>
            <input type="password" id="student_password" name="student_password" placeholder="Enter your password" required>
            
            <label for="confirm_password"><b>Confirm Password</b></label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                
            <label for="student_gender"><b>Gender</b></label>
            <select id="student_gender" name="student_gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
                
            <label for="student_student_email"><b>Student Email</b></label>
            <input type="email" id="student_student_email" name="student_student_email" placeholder="Enter your student email" required>
                
            <button type="submit" class="login-button">Sign up</button>
        </form>
    </div>
</div>

</body>
</html>
