<?php 
  include '../../db.php';

  if(isset($_POST['edit'])){
    $id = $_GET['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender-select']);
    $race = mysqli_real_escape_string($conn, $_POST['race-select']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone-number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $personalEmail = mysqli_real_escape_string($conn, $_POST['personal-email']);

    $sql = "UPDATE lecturer SET lecturer_name = ?, lecturer_gender = ?, lecturer_race = ?, lecturer_phone_number = ?, lecturer_email = ?, lecturer_personal_email = ? WHERE lecturer_id = ? AND lecturer_archive = 0";

    if (empty($name) || empty($gender) || empty($race) || empty($phone) || empty($email) || empty($id)) {
        echo "All fields are required.";
        exit();
    }

    $stmt = mysqli_stmt_init($conn);
    
    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "sssssss", $name, $gender, $race, $phone, $email, $personalEmail, $id);

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo '<script>alert("Lecturer edited successfully"); window.location.href = "../../lecturer.php";</script>';
        exit();
      } else {
        echo "Error updating lecturer: " . mysqli_error($conn);
      }
    } else {
      echo "Prepare statement error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>