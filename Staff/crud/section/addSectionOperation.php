<?php
include '../../db.php';

if (isset($_POST['add'])) {
  $stmt = $conn->prepare("INSERT INTO section (course_code, section_number, section_quota, section_day, section_start_time, section_end_time, section_location, lecturer_id, section_type, section_duration) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

  $stmt->bind_param("siissssisi", $courseCode, $sectionNumber, $sectionQuota, $sectionDay, $sectionStartTime, $sectionEndTime, $sectionLocation, $lecturerId, $sectionType, $sectionDuration);

  $courseCode = $_POST['course-code'];
  $sectionNumber = $_POST['section-number'];
  $sectionQuota = $_POST['section-quota'];
  $sectionDay = $_POST['section-day'];
  $sectionType = $_POST['section-type'];
  $sectionStartTime = $_POST['section-start-time'];
  $sectionEndTime = $_POST['section-end-time'];
  $sectionLocation = $_POST['section-location'];
  $lecturerId = $_POST['lecturer'];
  $sectionDuration = $_POST['section-duration'];

  if ($stmt->execute()) {
    $stmt->close();
    mysqli_close($conn);

    echo '<script>alert("Section added successfully"); window.location.href = "../../section.php";</script>';
    exit();
  } else {
    echo "Error: " . $stmt->error;
  }
} else {
  echo "Invalid request";
}

mysqli_close($conn);
?>