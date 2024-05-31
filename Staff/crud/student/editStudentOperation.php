<?php
include '../../db.php';

if (isset($_POST['edit'])) {
    // Prepare all input variables
    $matricNumberGet = $_GET['matricNumber'];
    $matricNumber = $_POST['matric-number'];
    $name = $_POST['name'];
    $icNumber = $_POST['ic-number'];
    $dob = $_POST['date-of-birth'];
    $gender = $_POST['gender-select'];
    $race = $_POST['race-select'];
    $nationality = $_POST['nationality-select'];
    $phoneNumber = $_POST['phone-number'];
    $studentEmail = $_POST['email'];
    $personalEmail = $_POST['personal-email'];
    $muetBand = $_POST['muet-band-select'];
    $preUResult = $_POST['pre-u-result'];

    // SQL query with prepared statement
    $sql = "UPDATE student SET 
            student_matric_number = ?,
            student_name = ?,
            student_IC = ?,
            student_DOB = ?,
            student_gender = ?,
            student_race = ?,
            student_nationality = ?,
            student_phone_number = ?,
            student_student_email = ?,
            student_personal_email = ?,
            student_muet_band = ?,
            student_pre_university_result = ?
            WHERE student_matric_number = ?";

    // Prepare statement
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssssssssssss", 
            $matricNumber, $name, $icNumber, $dob, $gender, $race, $nationality, 
            $phoneNumber, $studentEmail, $personalEmail, $muetBand, 
            $preUResult, $matricNumberGet);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            echo '<script>alert("Student record updated successfully"); window.location.href = "../../student.php";</script>';
            exit();
        } else {
            echo "Error updating student record: " . mysqli_stmt_error($stmt);
        }
    } else {
        echo "Prepare statement error: " . mysqli_error($conn);
    }
}
?>