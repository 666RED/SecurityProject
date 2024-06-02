<?php 
session_start();

if (!isset($_SESSION['lecturerID'])) {
    echo 'Please login first <br>';
    echo 'Click <a href="index.php">here</a> to login';
    exit();
} else {
    include "../db.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $lecturerID = $_SESSION['lecturerID'];
        $phoneNumber = mysqli_real_escape_string($conn, $_POST['phone-number']);
        $personalEmail = mysqli_real_escape_string($conn, $_POST['personal-email']);

        // Validate input
        if (preg_match("/^[0-9]{9,11}$/", $phoneNumber) && filter_var($personalEmail, FILTER_VALIDATE_EMAIL)) {
            $sql = "UPDATE lecturer SET lecturer_phone_number = ?, lecturer_personal_email = ? WHERE lecturer_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $phoneNumber, $personalEmail, $lecturerID);

            if ($stmt->execute()) {
                echo "<script>alert('Profile updated successfully!');
                window.location.href = '../course.php';
                </script>";
            } else {
                echo "Error updating profile: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Invalid phone number or email.";
        }
    } else {
        echo "Invalid request method.";
    }

    $conn->close();
}