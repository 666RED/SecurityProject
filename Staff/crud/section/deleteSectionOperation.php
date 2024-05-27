<?php
  include '../../db.php';

  if (isset($_GET['code']) && isset($_GET['number']) && isset($_GET['type'])) {
    $courseCode = $_GET['code'];
    $sectionNumber = $_GET['number'];
    $sectionType = $_GET['type'];

    $sql = "DELETE FROM section WHERE course_code = ? AND section_number = ? AND section_type = ?";

    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "sis", $courseCode, $sectionNumber, $sectionType);

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        echo '<script>alert("Section deleted successfully"); window.location.href = "../../section.php";</script>';
        exit();
      } else {
        echo "Error deleting section: " . mysqli_stmt_error($stmt);
      }
    } else {
      echo "Prepare statement error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>