<?php
include '../../db.php';

if (isset($_POST['course_code'])) {
  $id = $_GET['id'];
  $courseCode = mysqli_real_escape_string($conn, $_POST['course_code']);

  $sql = "SELECT * FROM course WHERE course_code = '$courseCode' AND course_code != '$id'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    echo 'exists';
  } else {
    echo 'not_exists';
  }

  mysqli_close($conn);
}
?>