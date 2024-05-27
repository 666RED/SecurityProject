<?php 
  include '../../db.php';

  if(isset($_POST['edit'])){ 
    $courseCode = $_GET['code'];
    $sectionNumber = $_GET['number'];
    $sectionType = $_GET['type'];

    $sectionQuota = $_POST['section-quota'];
    $sectionDay = $_POST['section-day'];
    $sectionStartTime = $_POST['section-start-time'];
    $sectionEndTime = $_POST['section-end-time'];
    $sectionLocation = $_POST['section-location'];
    $lecturerId = $_POST['lecturer'];
    $sectionDuration = $_POST['section-duration'];

    $stmt = $conn->prepare("UPDATE section SET course_code = ?,section_number = ?, section_quota = ?, section_day = ?,section_start_time = ?, section_end_time = ?, section_location = ?, lecturer_id = ?, section_type = ?, section_duration = ? WHERE course_code = ? AND section_number = ? AND section_type = ?");

    $stmt->bind_param("siissssssisis", $courseCode, $sectionNumber, $sectionQuota, $sectionDay, $sectionStartTime, $sectionEndTime, $sectionLocation, $lecturerId, $sectionType, $sectionDuration,$courseCode, $sectionNumber, $sectionType);

    if ($stmt->execute()) {
      echo '<script>alert("Section edited successfully"); window.location.href = "../../section.php";</script>';
    } else {
      echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
  }
?>