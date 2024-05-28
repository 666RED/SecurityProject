<?php
  include '../../db.php';

  if (isset($_GET['id'])) {
    $code = $_GET['id'];

    $sql = "UPDATE section SET section_archive = 1 WHERE course_code = ? and section_archive = 0";

    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $code);

      if (!mysqli_stmt_execute($stmt)) {
        echo "Error archiving sections: " . mysqli_stmt_error($stmt);
      }
    } else {
      echo "Prepare statement error: " . mysqli_stmt_error($stmt);
    }

    $sql = "UPDATE course SET course_archive = 1 WHERE course_code = ? and course_archive = 0";

    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $code);

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo '<script>alert("Course archived successfully"); window.location.href = "../../course.php";</script>';
        exit();
      } else {
        echo "Error archiving course: " . mysqli_stmt_error($stmt);
      }
    } else {
      echo "Prepare statement error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>