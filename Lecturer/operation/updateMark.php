<?php 
include '../db.php';

if(isset($_POST["update"])){
  // Get and sanitize form data
  $matricNumber = mysqli_real_escape_string($conn, $_POST['matric-number']);
  $courseCode = mysqli_real_escape_string($conn, $_POST['course-code']);
  $section = mysqli_real_escape_string($conn, $_POST['section-name']);
  $quizMark = mysqli_real_escape_string($conn, $_POST['quiz-mark']);
  $assignmentMark = mysqli_real_escape_string($conn, $_POST['assignment-mark']);
  $testMark = mysqli_real_escape_string($conn, $_POST['test-mark']);
  $projectMark = mysqli_real_escape_string($conn, $_POST['project-mark']);
  $courseworkMark = mysqli_real_escape_string($conn, $_POST['coursework-mark']);
  $finalMark = mysqli_real_escape_string($conn, $_POST['Final-mark']);
  $grade = mysqli_real_escape_string($conn, $_POST['grade']);

  // Update the data in the database using prepared statements
  $sql = "UPDATE student_section SET 
  quiz_mark = ?, 
  assignment_mark = ?, 
  test_mark = ?, 
  project_mark = ?, 
  course_mark = ?, 
  final_mark = ?, 
  course_grade = ?
  WHERE student_matric_number = ? AND course_code = ? AND section_number = ?";

  if ($stmt = $conn->prepare($sql)) {
  // Bind the parameters
  $stmt->bind_param("ddddddssss", $quizMark, $assignmentMark, $testMark, $projectMark, $courseworkMark, $finalMark, $grade, $matricNumber, $courseCode, $section);

  // Execute the statement
  if ($stmt->execute()) {
  echo "<script>alert('Record updated successfully.');
  window.location.href = '../section.php?course_code=$courseCode&section_number=$section';
  </script>";
  } else {
  echo "Error updating record: " . $stmt->error;
  }

  // Close the statement
  $stmt->close();
  } else {
  echo "Error preparing statement: " . $conn->error;
  }

  // Close the connection
  $conn->close();
}