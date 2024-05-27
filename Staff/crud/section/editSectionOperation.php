<?php 
  include '../../db.php';

  if(isset($_POST['edit'])){ 
    $sectionId = $_GET['id'];

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

    $stmt = $conn->prepare("UPDATE section SET course_code = ?,section_number = ?, section_quota = ?, section_day = ?,section_start_time = ?, section_end_time = ?, section_location = ?, lecturer_id = ?, section_type = ?, section_duration = ? WHERE section_id = ?");

    $stmt->bind_param("siissssssii", $courseCode, $sectionNumber, $sectionQuota, $sectionDay, $sectionStartTime, $sectionEndTime, $sectionLocation, $lecturerId, $sectionType, $sectionDuration,$sectionId);

    if ($stmt->execute()) {
      echo '<script>alert("Section edited successfully"); window.location.href = "../../section.php";</script>';
    } else {
      echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
  }
?>