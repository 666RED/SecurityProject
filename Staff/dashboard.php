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
  <link rel="stylesheet" href="./styles/dashboard.css">
  <link rel="stylesheet" href="./styles/style.css">
  <link rel="stylesheet" href="./styles/sidebar.css">
</head>

<body>
  <?php 
    // function getTotal($name){

    //   include 'db.php';

    //   $query = "SELECT COUNT(*) AS total_count FROM $name";

    //   $result = mysqli_query($conn, $query);

    //   if(mysqli_num_rows($result) > 0) {
    //     while($row = mysqli_fetch_assoc($result)) {
    //       return $row['total_count'];
    //     }
    //   }
    // }

    // function getTotalContact(){

    //   include 'db.php';

    //   $query = "SELECT COUNT(*) AS total_count FROM contact_us WHERE respond != 1";

    //   $result = mysqli_query($conn, $query);

    //   if(mysqli_num_rows($result) > 0) {
    //     while($row = mysqli_fetch_assoc($result)) {
    //       return $row['total_count'];
    //     }
    //   }
    // }

    // $numOfProduct = getTotal('product');
    // $numOfEvent = getTotal('event');
    // $numOfContact = getTotalContact();
  ?>
  <div class="container-fluid">
    <!-- sidebar -->
    <div class="bg-dark text-white sidebar">
      <a href="dashboard.php" class="btn nav-btn text-white d-block text-start selected">Dashboard</a>
      <a href="course.php" class="btn nav-btn text-white d-block text-start">Course</a>
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
          <div class="col-lg-4 col-sm-12">
            <div class="card mx-auto my-3 card-1" onclick="window.location.href = 'Course.php'">
              <div class="card-body">
                <h5 class="card-title">Total Course</h5>
                <!-- <p class="card-text"><?php echo $numOfProduct;?></p> -->
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-sm-12">
            <div class="card mx-auto my-3 card-2" onclick="window.location.href = 'lecturer.php'">
              <div class="card-body">
                <h5 class="card-title">Total Lecturer</h5>
                <!-- <p class="card-text"><?php echo $numOfEvent?></p> -->
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-sm1-12">
            <div class="card mx-auto my-3 card-3" onclick="window.location.href = 'student.php'">
              <div class="card-body">
                <h5 class="card-title">Total Student</h5>
                <!-- <p class="card-text"><?php echo $numOfContact;?></p> -->
              </div>
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