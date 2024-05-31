<?php
  include '../../db.php';

  $lecturerName = $_GET['lecturerName']; 

  $sql = "SELECT * FROM lecturer WHERE lecturer_name LIKE ? AND lecturer_archive = 0 ORDER BY lecturer_name ";

  $stmt = $conn->prepare($sql);

  $lecturerNameParam = "%$lecturerName%";
  $stmt->bind_param("s", $lecturerNameParam);

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