<?php
  include '../../db.php';

  $courseCode = $_GET['courseCode']; 

  $sql = "SELECT s.*, l.lecturer_name 
    FROM section s
    INNER JOIN lecturer l ON s.lecturer_id = l.lecturer_id
    WHERE s.course_code LIKE ?
    ORDER BY s.course_code, s.section_number";

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