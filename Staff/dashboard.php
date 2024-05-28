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
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./styles/dashboard.css">
  <link rel="stylesheet" href="./styles/style.css">
  <link rel="stylesheet" href="./styles/sidebar.css">
</head>

<body>
  <?php 
    function getTotal($name){

      include 'db.php';

      $query = "SELECT COUNT(*) AS total_count FROM $name WHERE ${name}_archive = 0";

      $result = mysqli_query($conn, $query);

      if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          return $row['total_count'];
        }
      }
    }

    $numOfCourse = getTotal('course');
    $numOfLecturer = getTotal('lecturer');
    $numOfStudent = getTotal('student');
  ?>
  <div class="container-fluid">
    <!-- sidebar -->
    <div class="bg-dark text-white sidebar">
      <a href="dashboard.php" class="btn nav-btn text-white d-block text-start selected">Dashboard</a>
      <a href="course.php" class="btn nav-btn text-white d-block text-start">Course</a>
      <a href="section.php" class="btn nav-btn text-white d-block text-start">Section</a>
      <a href="lecturer.php" class="btn nav-btn text-white d-block text-start">Lecturer</a>
      <a href="student.php" class="btn nav-btn text-white d-block text-start">Student</a>
      <a href="clearId.php"
        class="btn nav-btn text-white d-block text-start position-absolute w-100 bottom-0">Logout</a>
    </div>

    <div class="main-content">
      <h1 class="title">Dashboard</h1>
      <!-- card -->
      <div class="my-5 card-container">
        <div class="row">
          <!-- COURSE -->
          <div class="col-4">
            <div class="card w-75 mx-auto my-3 pb-3" onclick="window.location.href = 'Course.php'">
              <div class="card-body card-title-container">
                <i class="fa-solid fa-book fs-1"></i>
                <h5 class="card-title">Total Course</h5>
              </div>
              <p class="card-text"><?php echo $numOfCourse;?></p>
            </div>
          </div>
          <!-- LECTURER -->
          <div class="col-4">
            <div class="card w-75 mx-auto my-3 pb-3" onclick="window.location.href = 'lecturer.php'">
              <div class="card-body card-title-container">
                <i class="fa-solid fa-chalkboard-user fs-1"></i>
                <h5 class="card-title">Total Lecturer</h5>
              </div>
              <p class="card-text"><?php echo $numOfLecturer?></p>
            </div>
          </div>
          <!-- STUDENT -->
          <div class="col-4">
            <div class="card w-75 mx-auto my-3 pb-3" onclick="window.location.href = 'student.php'">
              <div class="card-body card-title-container">
                <i class="fa-solid fa-user fs-1"></i>
                <h5 class="card-title">Total Student</h5>
              </div>
              <p class="card-text"><?php echo $numOfStudent;?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>

<?php 
  } 
?>