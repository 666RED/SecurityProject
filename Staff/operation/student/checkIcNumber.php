<?php
  include '../../db.php';

  if (isset($_POST['icNumber'])) {
    $icNumber = $_POST['icNumber'];

    $sql = "SELECT * FROM student WHERE student_IC = ?";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $icNumber);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);

      if (mysqli_stmt_num_rows($stmt) > 0) {
        echo 'exists';
      } else {
        echo 'not_exists';
      }

      mysqli_stmt_close($stmt);
    } else {
      echo 'error';
    }
    mysqli_close($conn);
  }
?>