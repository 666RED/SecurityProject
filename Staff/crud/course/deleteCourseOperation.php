<?php
  include '../../db.php';

  if (isset($_GET['id'])) {
    $code = $_GET['id'];

    $sql = "DELETE FROM course WHERE course_code = ?";

    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $code);

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo '<script>alert("Course deleted successfully"); window.location.href = "../../course.php";</script>';
        exit();
      } else {
        echo "Error deleting course: " . mysqli_stmt_error($stmt);
      }
    } else {
      echo "Prepare statement error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>