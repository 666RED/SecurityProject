<?php
  include '../../db.php';

  $studentMatricNumber = $_GET['studentMatricNumber']; 

  $sql = "SELECT * FROM student WHERE student_matric_number LIKE ? AND student_archive = 0 ORDER BY student_matric_number ";

  $stmt = $conn->prepare($sql);

  $studentMatricNumberParam = "%$studentMatricNumber%";
  $stmt->bind_param("s", $studentMatricNumberParam);

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