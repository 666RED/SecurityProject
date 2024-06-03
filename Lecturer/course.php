<?php 
  session_start();

  if(!isset($_SESSION['lecturerID'])) {
    echo 'Please login first <br>';
    echo 'Click <a href="index.php">here<a/> to login';
  }else {
    include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course</title>
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
    <!-- SIDEBAR -->
    <div class="bg-dark text-white sidebar">
      <a href="course.php" class="btn nav-btn text-white d-block text-start selected">Course</a>
      <a href="profile.php" class="btn nav-btn text-white d-block text-start">Profile</a>
      <a href="updatePassword.php" class ="btn nav-btn text-white d-block text-start">Update<br>Password</a>
      <a href="clearId.php"
        class="btn nav-btn text-white d-block text-start position-absolute w-100 bottom-0">Logout</a>
    </div>

    <div class="main-content">
      <h1 class="title">Course</h1>
        <!-- SECRCH BAR -->
        <div class="position-relative d-inline">
          <input type="text" class="ps-1 pe-4 py-1 rounded mt-2" placeholder="Course code" id="courseCodeInput">
          <i class="fas fa-search position-absolute end-0 top-50 translate-middle-y me-2"></i>
        </div>
      </form>
      <!-- TABLE -->
      <table class="table table-striped table-bordered border-dark mt-4" id="courseTable">
        <!-- TABLE HEAD -->
        <thead>
          <div class="row">
            <th scope="col" class="col-1 text-center">
              #
            </th>
            <th scope="col" class="col-2 text-center">
              Course code
            </th>
            <th scope="col" class="col-3">
              Name
            </th>
            <th scope="col" class="col-2 text-center">
              Credit hour
            </th>
            <th scope="col" class="col-2 text-center">
              Section
            </th>
            <th scope="col" class="col-2 text-center">
              Operation
            </th>
          </div>
        </thead>
        <!-- TABLE BODY -->
        <tbody>
          <?php 
              $count = 1;

              $lecturerID = mysqli_real_escape_string($conn, $_SESSION['lecturerID']);

              $sql = "SELECT DISTINCT s.course_code, c.course_name, c.course_credit_hour, s.section_number
              FROM section s 
              JOIN course c ON s.course_code = c.course_code 
              WHERE s.section_archive = 0 && s.lecturer_id = $lecturerID
              ORDER BY s.course_code, s.section_number;";

              $result = mysqli_query($conn, $sql);

              if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
            ?>
          <!-- TABLE ROW -->
          <tr>
            <td scope="row" class="text-center"><?php echo $count++?></td>
            <td class="text-center"><?php echo $row["course_code"]?></td>
            <td><?php echo $row["course_name"]?></td>
            <td class="text-center"><?php echo $row["course_credit_hour"]?></td>
            <td class="text-center"><?php echo $row["section_number"]?></td>
            <!-- OPERATION -->
            <td>
              <div class="row text-center">
                <a href="./section.php?course_code=<?php echo $row["course_code"]?>&section_number=<?php echo $row["section_number"]; ?>">
                  <i class="fa-solid fa-eye text-primary"></i>
                </a>
            </td>
          </tr>
          <?php 
              }
            }else {
              echo  
                '<tr>
                  <td colspan="8" class="text-center">No sections found</td>
                </tr>';
            }
            mysqli_close( $conn );
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- JS SCRIPT -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
  // CLEAR SEARCH INPUT
  function init() {
    document.getElementById("courseCodeInput").value = "";
  }
  window.onload = init;

  // SEARCH
  $(document).ready(function() {
    $('#courseCodeInput').on('input', function() {
      var courseCode = $(this).val().trim();

      $.ajax({
        url: 'operation/searchCourse.php',
        method: 'GET',
        data: {
          courseCode: courseCode
        },
        success: function(response) {
          $('#courseTable tbody').empty();
          console.log(response);  // Log the JSON response to the console
          if (response.length > 0) {
            response.forEach((course, index) => {
              $('#courseTable tbody').append(`
                  <tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center">${course.course_code}</td>
                    <td>${course.course_name}</td>
                    <td class="text-center">${course.course_credit_hour}</td>
                    <td class="text-center">${course.section_number}</td>
                    <td>
                      <div class="row text-center">
                        <a href="./section.php?course_code=${course.course_code}&section_number=${course.section_number}">
                          <i class="fa-solid fa-eye text-primary"></i>
                        </a>
                    </td>
                  </tr>
                `);
            });
          } else {
            $('#courseTable tbody').append(`
                <tr>
                  <td colspan="6" class="text-center">No courses found</td>
                </tr>
              `);
          }
        },
        error: function(xhr, status, error) {
          console.error('Error searching:', error);
        }
      });
    });
  });
  </script>
</body>

</html>
<?php 
  }
?>