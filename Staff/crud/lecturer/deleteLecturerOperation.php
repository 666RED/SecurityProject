<?php
  include '../../db.php';

  if (isset($_GET['id'])) {
    $lecturerId = $_GET['id'];

    $sql = "UPDATE lecturer SET lecturer_archive = 1 WHERE lecturer_id = ? AND lecturer_archive = 0";

    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "i", $lecturerId);

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo '<script>alert("Lecturer archived successfully"); window.location.href = "../../lecturer.php";</script>';
        exit();
      } else {
        echo "Error archiving lecturer: " . mysqli_stmt_error($stmt);
      }
    } else {
      echo "Prepare statement error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>