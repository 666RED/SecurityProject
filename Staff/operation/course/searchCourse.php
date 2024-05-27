<?php
  include '../../db.php';

  $courseCode = $_GET['courseCode']; 

  $sql = "SELECT * FROM course WHERE course_code LIKE ? ORDER BY course_credit_hour, course_code";

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