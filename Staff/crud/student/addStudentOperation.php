<?php
include '../../db.php';

if (isset($_POST['add'])) {
    $matricNumber = trim($_POST['matric-number']);
    $name = trim($_POST['name']);
    $icNumber = trim($_POST['ic-number']);
    $dob = trim($_POST['date-of-birth']);
    $gender = trim($_POST['gender-select']);
    $race = trim($_POST['race-select']);
    $nationality = trim($_POST['nationality-select']);
    $phoneNumber = trim($_POST['phone-number']);
    $studentEmail = trim($_POST['email']);
    $personalEmail = trim($_POST['personal-email']);
    $muetBand = trim($_POST['muet-band-select']);
    $preUResult = trim($_POST['pre-u-result']);
    $rawPassword = trim($_POST['password']);

    if (empty($matricNumber) || empty($name) || empty($icNumber) || empty($dob) || empty($gender) || empty($race) || empty($nationality) || empty($phoneNumber) || empty($studentEmail) || empty($rawPassword)) {
      echo "Error: All fields are required.";
      exit();
    }

    $password = password_hash($rawPassword, PASSWORD_DEFAULT);

    $sql = "INSERT INTO student (student_matric_number, student_name, student_IC, student_DOB, student_gender, student_race, student_nationality, student_phone_number, student_student_email, student_personal_email, student_muet_band, student_pre_university_result, student_password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "sssssssssssss", $matricNumber, $name, $icNumber, $dob, $gender, $race, $nationality, $phoneNumber, $studentEmail, $personalEmail, $muetBand, $preUResult, $password);

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo '<script>alert("Student added successfully"); window.location.href = "../../student.php";</script>';
        exit();
      } else {
        echo "Error: " . mysqli_stmt_error($stmt);
      }
    } else {
      echo "Prepare statement error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>