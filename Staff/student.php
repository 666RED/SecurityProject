<?php 
  session_start();

  if(!isset($_SESSION['admin'])) {
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
      <!-- ADD NEW BUTTON -->
      <button class="add-new-button position-absolute d-flex flex-column align-items-center mt-3 me-3"
        onclick="window.location.href = 'operation/student/addStudent.php'">Add New</button>
      <!-- SECRCH BAR -->
      <form autocomplete="off">
        <div class="position-relative d-inline">
          <input type="text" class="ps-1 pe-4 py-1 rounded mt-2" placeholder="Student Matric Number"
            id="studentMatricNumberInput">
          <i class="fas fa-search position-absolute end-0 top-50 translate-middle-y me-2"></i>
        </div>
      </form>
      <!-- TABLE -->
      <table class="table table-striped table-bordered border-dark mt-4" id="studentTable">
        <!-- TABLE HEAD -->
        <thead>
          <div class="row">
            <th scope="col" class="col-1 text-center">#</th>
            <th scope="col" class="col-2">Matric Number</th>
            <th scope="col" class="col-3">Name</th>
            <th scope="col" class="col-2">Email</th>
            <th scope="col" class="col-2">Phone number</th>
            <th scope="col" class="col-2 text-center">
              Operation
            </th>
          </div>
        </thead>
        <!-- TABLE BODY -->
        <tbody>
          <?php 
            $count = 1;

            $sql = "SELECT student_matric_number, student_name, student_phone_number, student_student_email FROM student WHERE student_archive = 0 ORDER BY student_matric_number";

            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_assoc($result)) {
          ?>
          <!-- TABLE ROW -->
          <tr>
            <td scope="row" class="text-center"><?php echo $count++ ?></td>
            <td scope="row"><?php echo $row["student_matric_number"] ?></td>
            <td scope="row"><?php echo $row["student_name"] ?></td>
            <td scope="row"><?php echo $row["student_student_email"] ?></td>
            <td scope="row"><?php echo $row["student_phone_number"] ?></td>
            <!-- OPERATION -->
            <td>
              <div class="row">
                <div class="col-4 text-center">
                  <a
                    href="./operation/student/viewStudent.php?matricNumber=<?php echo $row["student_matric_number"] ?>">
                    <i class="fa-solid fa-eye text-primary"></i>
                  </a>
                </div>
                <div class="col-4 text-center">
                  <a
                    href="./operation/student/editStudent.php?matricNumber=<?php echo $row["student_matric_number"] ?>">
                    <i class="fa-solid fa-pencil text-success"></i>
                  </a>
                </div>
                <div class="col-4 text-center">
                  <a href="#">
                    <i class="fa-solid fa-trash text-danger"
                      onclick="deleteStudent('<?php echo $row['student_matric_number']?>', '<?php echo htmlspecialchars($row['student_name'])?>')"
                      name="delete"></i>
                  </a>
                </div>
              </div>
            </td>
          </tr>
          <?php 
              }
            }else {
              echo  
                '<tr>
                  <td colspan="8" class="text-center">No student found</td>
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
    document.getElementById("studentMatricNumberInput").value = "";
  }
  window.onload = init;

  const deleteStudent = (matricNumber, name) => {
    const result = confirm(`Archive ${name}?`);
    if (result) {
      window.location.href = `crud/student/deleteStudentOperation.php?matricNumber=${matricNumber}`;
    }
  }

  // SEARCH
  $(document).ready(function() {
    $('#studentMatricNumberInput').on('input', function() {
      var studentMatricNumber = $(this).val().trim();

      $.ajax({
        url: 'operation/student/searchStudent.php',
        method: 'GET',
        data: {
          studentMatricNumber: studentMatricNumber
        },
        success: function(response) {
          $('#studentTable tbody').empty();

          if (response.length > 0) {
            response.forEach((student, index) => {
              $('#studentTable tbody').append(`
                  <tr>
                    <td class="text-center">${index + 1}</td>
                    <td>${student.student_matric_number}</td>
                    <td>${student.student_name}</td>
                    <td>${student.student_student_email}</td>
                    <td>${student.student_phone_number}</td>
                    <td class="text-center">
                      <div class="row">
                        <div class="col-4 text-center">
                          <a href="./operation/student/viewStudent.php?matricNumber=${student.student_matric_number}">
                            <i class="fa-solid fa-eye text-primary"></i>
                          </a>
                        </div>
                        <div class="col-4 text-center">
                          <a href="./operation/student/editStudent.php?matricNumber=${student.student_matric_number}">
                            <i class="fa-solid fa-pencil text-success"></i>
                          </a>
                        </div>
                        <div class="col-4 text-center">
                          <a href="#" onclick="deleteStudent('${student.student_matric_number}', '${student.student_name}')">
                            <i class="fa-solid fa-trash text-danger"></i>
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                `);
            });
          } else {
            $('#studentTable tbody').append(`
                <tr>
                  <td colspan="7" class="text-center">No students found</td>
                </tr>
              `);
          }
        },
        error: function(xhr, status, error) {
          console.error('Error searching students:', error);
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