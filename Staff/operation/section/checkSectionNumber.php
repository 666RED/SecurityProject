<?php
include '../../db.php'; 

if (isset($_POST['sectionNumber']) && isset($_POST['courseCode']) && isset($_POST['type'])) {
  $sectionNumber = mysqli_real_escape_string($conn, $_POST['sectionNumber']);
  $courseCode = mysqli_real_escape_string($conn, $_POST['courseCode']);
  $type = mysqli_real_escape_string($conn, $_POST['type']);

  $sql = "SELECT * FROM section WHERE section_number = '$sectionNumber' AND course_code = '$courseCode' AND section_type = '$type'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    echo 'exists';
  } else {
    echo 'not_exists';
  }

  mysqli_close($conn);
}
?>