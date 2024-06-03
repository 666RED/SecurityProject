<?php
session_start();
include "../db.php";

// Check if the lecturer is logged in
if (!isset($_SESSION['lecturerID'])) {
    echo 'Please login first <br>';
    echo 'Click <a href="index.php">here</a> to login';
    exit;
}

// Check if the form was submitted
if (isset($_POST['update'])) {
    // Get the lecturerID from the session
    $lecturerID = $_SESSION['lecturerID'];

    // Get the POST data from the form submission
    $oldPassword = $_POST['oldpassword'];
    $newPassword = $_POST['newpassword'];
    $confirmNewPassword = $_POST['confirmnewpassword'];

    // Check if the new password and confirm password match
    if ($newPassword !== $confirmNewPassword) {
        echo 'New passwords do not match. Please try again.<br>';
        echo 'Click <a href="../updatePassword.php">here</a> to go back';
        exit;
    }

    // Fetch the current password from the database
    $sql = "SELECT lecturer_password FROM lecturer WHERE lecturer_id = ? AND lecturer_archive = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $currentPasswordHash = $row['lecturer_password'];

        // Verify the old password
        if (!password_verify($oldPassword, $currentPasswordHash)) {
            echo 'Old password is incorrect. Please try again.<br>';
            echo 'Click <a href="../updatePassword.php">here</a> to go back';
            exit;
        }

        // Encrypt the new password
        $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update the password in the database
        $updateSql = "UPDATE lecturer SET lecturer_password = ? WHERE lecturer_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $newPasswordHash, $lecturerID);

        if ($updateStmt->execute()) {
            echo "<script>alert('Password updated successfully!');
            window.location.href = '../course.php';
            </script>";
        } else {
            echo "Error updating profile: " . $stmt->error;
        }
    } else {
        echo 'Lecturer data is unavailable.<br>';
        echo 'Click <a href="profile.php">here</a> to go back';
    }
} else {
    echo 'Invalid request.<br>';
    echo 'Click <a href="updatePassword.php">here</a> to go back';
}

mysqli_close($conn);
