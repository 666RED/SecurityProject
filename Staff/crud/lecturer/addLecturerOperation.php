<?php 
  include '../../db.php';

  if(isset($_POST['add'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender-select']);
    $race = mysqli_real_escape_string($conn, $_POST['race-select']);
    $phoneNumber = mysqli_real_escape_string($conn, $_POST['phone-number']);
    $universityEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $personalEmail = mysqli_real_escape_string($conn, $_POST['personal-email']);
    $rawPassword = mysqli_real_escape_string($conn, $_POST['password']);

    $password = password_hash($rawPassword, PASSWORD_DEFAULT);

    $sql = "INSERT INTO lecturer (lecturer_name, lecturer_phone_number, lecturer_gender, lecturer_race, lecturer_email, lecturer_personal_email, lecturer_password) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "sssssss", $name, $phoneNumber, $gender, $race, $universityEmail, $personalEmail, $password);
      
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo '<script>alert("New lecturer added successfully"); window.location.href = "../../lecturer.php";</script>';
        exit();
      } else {
        echo "Error adding lecturer: " . mysqli_error($conn);
      }
  }else {
      echo "Prepare statement error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>