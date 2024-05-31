<?php
  include '../../db.php';

  if (isset($_GET['matricNumber'])) {
    $matricNumber = $_GET['matricNumber'];

    $sql = "UPDATE student SET student_archive = 1 WHERE student_matric_number = ? AND student_archive = 0";

    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $matricNumber);

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo '<script>alert("Student archived successfully"); window.location.href = "../../student.php";</script>';
        exit();
      } else {
        echo "Error archiving student: " . mysqli_stmt_error($stmt);
      }
    } else {
      echo "Prepare statement error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>