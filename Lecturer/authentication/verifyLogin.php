<?php 
  session_start();

  include '../db.php';

  if(isset($_POST['login'])){ 
    $userEmail = mysqli_real_escape_string($conn, $_POST['user-email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT lecturer_id, lecturer_password FROM lecturer WHERE lecturer_email = '$userEmail' && lecturer_archive = 0";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $lecturerId = $user["lecturer_id"];
        if (password_verify($password, $user['lecturer_password'])) {
            $_SESSION['lecturerID'] = $lecturerId;
            header('Location: ../course.php');
        } else {
            $_SESSION["errorMessage"] = "Incorrect password";
            header('Location: ../index.php');
        }
    }else {
      $_SESSION["errorMessage"] = "Incorrect user Email";
      header('Location: ../index.php');

    }
    mysqli_close($conn);
  }
?>