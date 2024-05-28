<?php 
  include '../../db.php';

  if(isset($_POST['edit'])){
    $code = $_GET['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $creditHour = mysqli_real_escape_string($conn, $_POST['credit-hour']);
    $courseCode = mysqli_real_escape_string($conn, $_POST['code']);

    $sql = "UPDATE course SET course_code = ?, course_name = ?, course_credit_hour = ? WHERE course_code = ?";

    if (empty($name) || empty($creditHour) || empty($code)) {
        echo "All fields are required.";
        exit();
    }

    $stmt = mysqli_stmt_init($conn);
    
    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "ssis", $courseCode, $name, $creditHour, $code);

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo '<script>alert("Course edited successfully"); window.location.href = "../../course.php";</script>';
        exit();
      } else {
        echo "Error updating course: " . mysqli_error($conn);
      }
    } else {
      echo "Prepare statement error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>