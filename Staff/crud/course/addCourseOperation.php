<?php 
  include '../../db.php';
  
  if(isset($_POST['add'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $creditHour = mysqli_real_escape_string($conn, $_POST['credit-hour']);
    $code = mysqli_real_escape_string($conn, $_POST['code']);

    if (empty($name) || empty($creditHour) || empty($code)) {
        echo "All fields are required.";
        exit();
    }
    
    $sql = "INSERT INTO course VALUES (?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);

  if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "ssi", $code, $name, $creditHour);

    if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      echo '<script>alert("New course added successfully"); window.location.href = "../../course.php";</script>';
      exit();
    } else {
      echo "Error adding course: " . mysqli_error($conn);
    }
  } else {
    echo "Prepare statement error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>