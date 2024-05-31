<?php 
include "../../db.php";

if (isset($_GET['courseCode'])) {
    $courseCode = mysqli_real_escape_string($conn, $_GET['courseCode']);

    $sql = "UPDATE student_section SET expired = 1 WHERE course_code = ?";

    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $courseCode);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            echo '<script>alert("Student sections marked as expired successfully"); window.location.href = "../../course.php";</script>';
            exit();
        } else {
            echo "Error reseting course: " . mysqli_stmt_error($stmt);
        }
    } else {
        echo "Prepare statement error: " . mysqli_error($conn);
    }
} else {
    echo "Course code not provided.";
}
?>