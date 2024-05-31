<?php
  include '../../db.php';

  if (isset($_POST['universityEmail'])) {
    $universityEmail = $_POST['universityEmail']; // No need to escape if using prepared statement

    // Prepare and bind the statement
    $sql = "SELECT * FROM lecturer WHERE lecturer_email = ?";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $universityEmail);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);

      if (mysqli_stmt_num_rows($stmt) > 0) {
        echo 'exists'; // University email already exists in the database
      } else {
        echo 'not_exists'; // University email is available
      }

      mysqli_stmt_close($stmt);
    } else {
      echo 'error'; // Query preparation error
    }

    mysqli_close($conn);
  }
?>