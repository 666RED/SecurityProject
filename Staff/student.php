<?php 
  session_start();

  if(!isset($_SESSION['admin'])) {
    echo 'Please login first <br>';
    echo 'Click <a href="index.php">here<a/> to login';
  }else {
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./styles/style.css">
  <link rel="stylesheet" href="./styles/sidebar.css">
</head>

<body>
  <div class="container-fluid">
    <!-- sidebar -->
    <div class="bg-dark text-white sidebar">
      <a href="dashboard.php" class="btn nav-btn text-white d-block text-start">Dashboard</a>
      <a href="course.php" class="btn nav-btn text-white d-block text-start">Course</a>
      <a href="section.php" class="btn nav-btn text-white d-block text-start">Section</a>
      <a href="lecturer.php" class="btn nav-btn text-white d-block text-start">Lecturer</a>
      <a href="student.php" class="btn nav-btn text-white d-block text-start selected">Student</a>
      <a href="clearId.php"
        class="btn nav-btn text-white d-block text-start position-absolute w-100 bottom-0">Logout</a>
    </div>

    <div class="main-content">
      <h1 class="title">Student</h1>
    </div>
  </div>
</body>

</html>

<?php 
  }
?>