<?php 
  session_start();

  if(!isset($_SESSION['lecturerID'])) {
    echo 'Please login first <br>';
    echo 'Click <a href="index.php">here<a/> to login';
  }else{
?>

<?php
  include '../../db.php';

  $lecturerID = mysqli_real_escape_string($conn, $_SESSION['lecturerID']);
  $courseCode = $_GET['courseCode']; 

  $sql = "SELECT DISTINCT s.course_code, c.course_name, c.course_credit_hour, s.section_number
  FROM section s 
  JOIN course c ON s.course_code = c.course_code 
  WHERE s.section_archive = 0 AND s.lecturer_id = $lecturerID AND s.course_code LIKE ?
  ORDER BY s.course_code, s.section_number;";

  $stmt = $conn->prepare($sql);

  $courseCodeParam = "%$courseCode%";
  $stmt->bind_param("s", $courseCodeParam);

  $stmt->execute();

  $result = $stmt->get_result();

  $courses = [];

  while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
  }

  $stmt->close();
  $conn->close();

  header('Content-Type: application/json');
  echo json_encode($courses);
  ?>

<?php 
}
?>