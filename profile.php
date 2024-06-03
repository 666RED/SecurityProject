<?php
require 'database.php';

session_start();

$student_student_email = $_SESSION['student_student_email']; // Assuming the student email is stored in session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch current data
    $sql = "SELECT * FROM student WHERE student_student_email='$student_student_email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $current_data = $result->fetch_assoc();
    } else {
        $error = "No user found.";
    }

    // Use current data if no new data is provided
    $student_matric_number = !empty($_POST['student_matric_number']) ? $_POST['student_matric_number'] : $current_data['student_matric_number'];
    $student_name = !empty($_POST['student_name']) ? $_POST['student_name'] : $current_data['student_name'];
    $student_password = !empty($_POST['student_password']) ? password_hash($_POST['student_password'], PASSWORD_DEFAULT) : $current_data['student_password'];
    $student_DOB = !empty($_POST['student_DOB']) ? $_POST['student_DOB'] : $current_data['student_DOB'];
    $student_gender = !empty($_POST['student_gender']) ? $_POST['student_gender'] : $current_data['student_gender'];
    $student_student_email = !empty($_POST['student_student_email']) ? $_POST['student_student_email'] : $current_data['student_student_email'];
    $student_phone_number = !empty($_POST['student_phone_number']) ? $_POST['student_phone_number'] : $current_data['student_phone_number'];
    $student_IC = !empty($_POST['student_IC']) ? $_POST['student_IC'] : $current_data['student_IC'];
    $student_nationality = !empty($_POST['student_nationality']) ? $_POST['student_nationality'] : $current_data['student_nationality'];
    $student_race = !empty($_POST['student_race']) ? $_POST['student_race'] : $current_data['student_race'];
    $student_personal_email = !empty($_POST['student_personal_email']) ? $_POST['student_personal_email'] : $current_data['student_personal_email'];
    $student_muet_band = !empty($_POST['student_muet_band']) ? $_POST['student_muet_band'] : $current_data['student_muet_band'];
    $student_pre_university_result = !empty($_POST['student_pre_university_result']) ? $_POST['student_pre_university_result'] : $current_data['student_pre_university_result'];

    // Update user information
    $sql = "UPDATE student SET 
        student_matric_number='$student_matric_number', 
        student_name='$student_name', 
        student_password='$student_password', 
        student_DOB='$student_DOB', 
        student_gender='$student_gender', 
        student_student_email='$student_student_email', 
        student_phone_number='$student_phone_number', 
        student_IC='$student_IC', 
        student_nationality='$student_nationality', 
        student_race='$student_race', 
        student_personal_email='$student_personal_email', 
        student_muet_band='$student_muet_band', 
        student_pre_university_result='$student_pre_university_result' 
        WHERE student_student_email='$student_student_email'";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Profile updated successfully";
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch current user data
$sql = "SELECT * FROM student WHERE student_student_email='$student_student_email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    $error = "No user found.";
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
            background-color: #f1f1f1;
        }
        .top-menu {
            background-color: #3780a3;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            height: 7%;
            overflow: hidden;
        }
        .top-menu a {
            float: left;
            display: block;
            color: black;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .top-menu a:hover {
            background-color: #ddd;
            color: black;
        }
        .top-menu a.right {
            float: right;
        }
        .form-container {
            width: 90%;
            max-width: 600px;
            padding: 25px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            margin: auto;
            margin-top: 50px;
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
            background-color: #3780a3;
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
        footer {
            background-color: #3780a3;
            color: black;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            position: auto;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

<!-- Top Menu -->
<div class="top-menu">
    <a href="homepage.php">Dashboard</a>
    <a href="profile.php">Profile</a>
    <a href="registration.php">Register</a>
    <a href="course.php">Courses</a>
    <a href="logout.php" class="right">Logout</a>
</div>

<!-- Main Content -->
<div class="form-container">
    <h1 class="w3-xxxlarge">Profile</h1>
    <p class="w3-large">Update your personal information.</p>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <form action="" method="post">
        <label for="student_matric_number">Matric Number</label>
        <input type="text" id="student_matric_number" name="student_matric_number" class="w3-input" maxlength="8" value="<?php echo $student['student_matric_number']; ?>">
        
        <label for="student_name">Name</label>
        <input type="text" id="student_name" name="student_name" class="w3-input" maxlength="50" value="<?php echo $student['student_name']; ?>">
        
        <label for="student_password">Password</label>
        <input type="password" id="student_password" name="student_password" class="w3-input" placeholder="Password">
        
        <label for="student_DOB">Date of Birth</label>
        <input type="date" id="student_DOB" name="student_DOB" class="w3-input" value="<?php echo $student['student_DOB']; ?>">
        
        <label for="student_gender">Gender</label>
        <select id="student_gender" name="student_gender" class="w3-select">
            <option value="" disabled selected>Select gender</option>
            <option value="male" <?php if($student['student_gender'] == 'male') echo 'selected'; ?>>Male</option>
            <option value="female" <?php if($student['student_gender'] == 'female') echo 'selected'; ?>>Female</option>
            <option value="other" <?php if($student['student_gender'] == 'other') echo 'selected'; ?>>Other</option>
        </select>
        
        <label for="student_student_email">Student Email</label>
        <input type="email" id="student_student_email" name="student_student_email" class="w3-input" maxlength="30" value="<?php echo $student['student_student_email']; ?>">
        
        <label for="student_phone_number">Phone Number</label>
        <input type="text" id="student_phone_number" name="student_phone_number" class="w3-input" maxlength="11" pattern="\d{11}" placeholder="Without ( - )" value="<?php echo $student['student_phone_number']; ?>">
        
        <label for="student_IC">IC</label>
        <input type="text" id="student_IC" name="student_IC" class="w3-input" maxlength="12" pattern="\d{12}" placeholder="Without ( - )" value="<?php echo $student['student_IC']; ?>">
        
        <label for="student_nationality">Nationality</label>
        <input type="text" id="student_nationality" name="student_nationality" class="w3-input" value="<?php echo $student['student_nationality']; ?>">
        
        <label for="student_race">Race</label>
        <input type="text" id="student_race" name="student_race" class="w3-input" value="<?php echo $student['student_race']; ?>">
        
        <label for="student_personal_email">Personal Email</label>
        <input type="email" id="student_personal_email" name="student_personal_email" class="w3-input" placeholder="Email" value="<?php echo $student['student_personal_email']; ?>">
        
        <label for="student_muet_band">MUET Band</label>
        <input type="text" id="student_muet_band" name="student_muet_band" class="w3-input" maxlength="1" placeholder="1 - 6" value="<?php echo $student['student_muet_band']; ?>">
        
        <label for="student_pre_university_result">Pre-University Result</label>
        <input type="text" id="student_pre_university_result" name="student_pre_university_result" class="w3-input" maxlength="4" pattern="\d(\.\d{1,2})?" placeholder="0.00" value="<?php echo $student['student_pre_university_result']; ?>">

        <button type="submit" class="w3-button w3-#3780a3 w3-margin-top">Update Profile</button>
    </form>
</div>

<!-- Footer -->
<footer>
    <p>Student Management System © 2024. All rights reserved.</p>
</footer>

</body>
</html>
