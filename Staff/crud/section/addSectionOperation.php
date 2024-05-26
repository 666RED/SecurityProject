<?php
include '../../db.php';

if (isset($_POST['add'])) {
  // Prepare the SQL statement with placeholders
  $stmt = $conn->prepare("INSERT INTO section (course_code, section_number, section_quota, section_day, section_start_time, section_end_time, section_location, lecturer_id, section_type, section_duration) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

  // Bind parameters to the prepared statement
  $stmt->bind_param("siissssssi", $courseCode, $sectionNumber, $sectionQuota, $sectionDay, $sectionStartTime, $sectionEndTime, $sectionLocation, $lecturerId, $sectionType, $sectionDuration);

  // Assign values from POST data to variables
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

  // Execute the prepared statement
  if ($stmt->execute()) {
    // Close statement and database connection
    $stmt->close();
    mysqli_close($conn);

    // Redirect after successful insertion
    echo '<script>alert("Section added successfully"); window.location.href = "../../section.php";</script>';
    exit();
  } else {
    // Display error message if execution fails
    echo "Error: " . $stmt->error;
  }
} else {
  // Handle invalid request scenario
  echo "Invalid request";
}

// Close database connection
mysqli_close($conn);
?>