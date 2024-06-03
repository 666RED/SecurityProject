<?php 
session_start();

if (!isset($_SESSION['lecturerID'])) {
  echo 'Please login first <br>';
  echo 'Click <a href="index.php">here</a> to login';
  exit();
}

if (isset($_GET['course_code']) && isset($_GET['section_number'])) {
    include 'db.php';
    $courseCode = mysqli_real_escape_string($conn, $_GET['course_code']);
    $sectionNumber = mysqli_real_escape_string($conn, $_GET['section_number']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    	integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    	integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    	crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./styles/sidebar.css">
</head>
<body>
<body>
  <div class="container-fluid">
    <!-- SIDEBAR -->
    <div class="bg-dark text-white sidebar">
      <a href="course.php" class="btn nav-btn text-white d-block text-start">Course</a>
      <a href="profile.php" class="btn nav-btn text-white d-block text-start">Profile</a>
      <a href="updatePassword.php" class ="btn nav-btn text-white d-block text-start">Update<br>Password</a>
      <a href="clearId.php"
        class="btn nav-btn text-white d-block text-start position-absolute w-100 bottom-0">Logout</a>
    </div>

    <div class="main-content">
      <h1 class="title">
				<?php 
					$sql="SELECT course_name FROM course where course_code = '$courseCode'";
					$result = mysqli_query($conn, $sql);
					if(mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)) {
							$courseName = $row["course_name"];
						}
					}
					echo $courseCode ." " .$courseName ."<br><i>Section:</i> " .$sectionNumber;
				?>
			</h1>
        <!-- SECRCH BAR -->
        <div class="position-relative d-inline">
          <input type="text" class="ps-1 pe-4 py-1 rounded mt-2" placeholder="Student Matric No" id="studentMaticInput">
          <i class="fas fa-search position-absolute end-0 top-50 translate-middle-y me-2"></i>
        </div>
      </form>
      <!-- TABLE -->
      <table class="table table-striped table-bordered border-dark mt-4" id="studentTable">
        <!-- TABLE HEAD -->
        <thead>
          <div class="row">
            <th scope="col" class="col-1 text-center">
              #
            </th>
            <th scope="col" class="col-2 text-center">
              Student Matric Number
            </th>
            <th scope="col" class="col-3">
              Name
            </th>
            <th scope="col" class="col-2 text-center">
              Coursework Mark
            </th>
            <th scope="col" class="col-2 text-center">
              Final exam Mark
            </th>
            <th scope="col" class="col-1 text-center">
              Grade
            </th>
						<th scope="col" class="col-1 text-center">
              Operation
            </th>
          </div>
        </thead>
        <!-- TABLE BODY -->
        <tbody>
          <?php 
              $count = 1;

              $lecturerID = mysqli_real_escape_string($conn, $_SESSION['lecturerID']);

              $sql = "SELECT ss.student_matric_number, s.student_name, ss.course_mark, ss.final_mark, ss.course_grade
              FROM student_section ss
              JOIN student s ON ss.student_matric_number = s.student_matric_number
              WHERE ss.expired = 0 AND student_archive = 0 AND ss.lecturer_id = $lecturerID AND ss.section_number = $sectionNumber AND ss.course_code = '$courseCode'
              ORDER BY ss.student_matric_number;";

              $result = mysqli_query($conn, $sql);

              if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
            ?>
          <!-- TABLE ROW -->
          <tr>
            <td scope="row" class="text-center"><?php echo $count++?></td>
            <td class="text-center"><?php echo $row["student_matric_number"]?></td>
            <td><?php echo $row["student_name"]?></td>
            <td class="text-center"><?php echo $row["course_mark"]?></td>
            <td class="text-center"><?php echo $row["final_mark"]?></td>
						<td class="text-center"><?php echo $row["course_grade"]?></td>
            <!-- OPERATION -->
            <td>
              <div class="row text-center">
                <a href="./student.php?student=<?php echo $row["student_matric_number"]?>&course_code=<?php echo $courseCode ?>&section_number=<?php echo $sectionNumber ?>">
                  <i class="fa-solid fa-pencil text-success"></i>
                </a>
            </td>
          </tr>
          <?php 
              }
            }else {
              echo  
                '<tr>
                  <td colspan="8" class="text-center">No Student found</td>
                </tr>';
            }
            mysqli_close( $conn );
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
  // CLEAR SEARCH INPUT
  function init() {
    document.getElementById("studentMaticInput").value = "";
  }
  window.onload = init;

  // SEARCH
  $(document).ready(function() {
    $('#studentMaticInput').on('input', function() {
      var student_matric_number = $(this).val().trim();
      var courseCode = "<?php echo $courseCode?>";
      var section_number = "<?php echo $sectionNumber ?>";

      $.ajax({
        url: 'operation/searchStudent.php',
        method: 'GET',
        data: {
          student_matric_number: student_matric_number,
          courseCode: courseCode,
          section_number:section_number
        },
        success: function(response) {
          $('#studentTable tbody').empty();
          console.log(response);  // Log the JSON response to the console
          if (response.length > 0) {
            response.forEach((student, index) => {
              $('#studentTable tbody').append(`
                  <tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center">${student.student_matric_number}</td>
                    <td>${student.student_name}</td>
                    <td class="text-center">${student.course_mark}</td>
                    <td class="text-center">${student.final_mark}</td>
                    <td class="text-center">${student.course_grade}</td>
                    <td>
                      <div class="row text-center">
                        <a href="./student.php?student=${student.student_matric_number}&course_code=${student.course_code}&section_number=${student.section_number}">
                          <i class="fa-solid fa-pencil text-success"></i>
                        </a>
                    </td>
                  </tr>
                `);
            });
          } else {
            $('#studentTable tbody').append(`
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
  </script>
</body>
</html>

<?php
} else {
    echo 'Course code or section number is missing.';
}
?>
