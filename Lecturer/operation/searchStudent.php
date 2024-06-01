<?php 
  session_start();

  if(!isset($_SESSION['lecturerID'])) {
    echo 'Please login first <br>';
    echo 'Click <a href="index.php">here<a/> to login';
  }else{
?>

<?php
  include '../db.php';

  $lecturerID = mysqli_real_escape_string($conn, $_SESSION['lecturerID']);
  $student_matric_number = $_GET['student_matric_number'];
  $courseCode = $_GET['courseCode']; 
  $section = $_GET['section_number'];

  $sql = "SELECT ss.student_matric_number, ss.course_code, ss.section_number, s.student_name, ss.course_mark, ss.final_mark, ss.course_grade
  FROM student_section ss
  JOIN student s ON s.student_matric_number = ss.student_matric_number
  WHERE ss.expired = 0 AND student_archive = 0 AND ss.lecturer_id = $lecturerID AND ss.section_number = $section AND 
  ss.course_code = '$courseCode' AND ss.student_matric_number LIKE ?
  ORDER BY ss.student_matric_number;";

  $stmt = $conn->prepare($sql);

  $student_matric_numberParam = "%$student_matric_number%";
  $stmt->bind_param("s", $student_matric_numberParam);

  $stmt->execute();

  $result = $stmt->get_result();

  $courses = [];

  while ($row = $result->fetch_assoc()) {
  $students[] = $row;
  }

  $stmt->close();
  $conn->close();

  header('Content-Type: application/json');
  echo json_encode($students);
  ?>  

<?php 
}
?>