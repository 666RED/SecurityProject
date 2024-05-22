<?php 
  session_start();

  include '../db.php';

  if(isset($_POST['login'])){
    $userId = mysqli_real_escape_string($conn, $_POST['user-id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM staff WHERE userId = '$userId'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin'] = $userId;
            header('Location: ../dashboard.php');
        } else {
            $_SESSION["errorMessage"] = "Incorrect password";
            header('Location: ../index.php');
        }
    }else {
      $_SESSION["errorMessage"] = "Incorrect user ID";
      header('Location: ../index.php');

    }
    mysqli_close($conn);
  }
?>