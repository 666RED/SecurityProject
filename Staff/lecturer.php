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
  <title>Lecturer</title>
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
      <a href="lecturer.php" class="btn nav-btn text-white d-block text-start selected">Lecturer</a>
      <a href="student.php" class="btn nav-btn text-white d-block text-start">Student</a>
      <a href="clearId.php"
        class="btn nav-btn text-white d-block text-start position-absolute w-100 bottom-0">Logout</a>
    </div>

    <div class="main-content">
      <h1 class="title">Lecturer</h1>
      <!-- ADD NEW BUTTON -->
      <button class="add-new-button position-absolute d-flex flex-column align-items-center mt-3 me-3"
        onclick="window.location.href = 'operation/lecturer/addLecturer.php'">Add New</button>
      <form autocomplete="off">
        <!-- SECRCH BAR -->
        <div class="position-relative d-inline">
          <input type="text" class="ps-1 pe-4 py-1 rounded mt-2" placeholder="Lecturer Name" id="lecturerNameInput">
          <i class="fas fa-search position-absolute end-0 top-50 translate-middle-y me-2"></i>
        </div>
      </form>
      <!-- TABLE -->
      <table class="table table-striped table-bordered border-dark mt-4" id="lecturerTable">
        <!-- TABLE HEAD -->
        <thead>
          <div class="row">
            <th scope="col" class="col-1 text-center">#</th>
            <th scope="col" class="col-3">Name</th>
            <th scope="col" class="col-1 text-center">Gender</th>
            <th scope="col" class="col-1 text-center">Race</th>
            <th scope="col" class="col-2">Phone number</th>
            <th scope="col" class="col-2">Email</th>
            <th scope="col" class="col-2 text-center">
              Operation
            </th>
          </div>
        </thead>
        <!-- TABLE BODY -->
        <tbody>
          <?php 
              $count = 1;

              $sql = "SELECT lecturer_id, lecturer_name, lecturer_gender, lecturer_race, lecturer_phone_number, lecturer_email FROM lecturer WHERE lecturer_archive = 0 ORDER BY lecturer_id";

              $result = mysqli_query($conn, $sql);

              if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
          ?>
          <!-- TABLE ROW -->
          <tr>
            <td scope="row" class="text-center"><?php echo $count++ ?></td>
            <td scope="row"><?php echo $row["lecturer_name"] ?></td>
            <td scope="row" class="text-center"><?php echo $row["lecturer_gender"] ?></td>
            <td scope="row" class="text-center"><?php echo $row["lecturer_race"] ?></td>
            <td scope="row"><?php echo $row["lecturer_phone_number"] ?></td>
            <td scope="row"><?php echo $row["lecturer_email"] ?></td>
            <!-- OPERATION -->
            <td>
              <div class="row">
                <div class="col-4 text-center">
                  <a href="./operation/lecturer/viewLecturer.php?id=<?php echo $row["lecturer_id"] ?>">
                    <i class="fa-solid fa-eye text-primary"></i>
                  </a>
                </div>
                <div class="col-4 text-center">
                  <a href="./operation/lecturer/editLecturer.php?id=<?php echo $row["lecturer_id"] ?>">
                    <i class="fa-solid fa-pencil text-success"></i>
                  </a>
                </div>
                <div class="col-4 text-center">
                  <a href="#">
                    <i class="fa-solid fa-trash text-danger"
                      onclick="deleteLecturer('<?php echo $row['lecturer_id']?>', '<?php echo htmlspecialchars($row['lecturer_name'])?>')"
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
                  <td colspan="8" class="text-center">No sections found</td>
                </tr>';
            }
            mysqli_close( $conn );
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
  // CLEAR SEARCH INPUT
  function init() {
    document.getElementById("lecturerIdInput").value = "";
  }
  window.onload = init;

  const deleteLecturer = (id, name) => {
    const result = confirm(`Archive ${name}?`);
    if (result) {
      window.location.href = `crud/lecturer/deleteLecturerOperation.php?id=${id}`;
    }
  }

  // SEARCH
  $(document).ready(function() {
    $('#lecturerNameInput').on('input', function() {
      var lecturerName = $(this).val().trim();

      $.ajax({
        url: 'operation/lecturer/searchLecturer.php',
        method: 'GET',
        data: {
          lecturerName: lecturerName
        },
        success: function(response) {
          $('#lecturerTable tbody').empty();

          if (response.length > 0) {
            response.forEach((lecturer, index) => {
              $('#lecturerTable tbody').append(`
                  <tr>
                    <td class="text-center">${index + 1}</td>
                    <td>${lecturer.lecturer_name}</td>
                    <td class='text-center'>${lecturer.lecturer_gender}</td>
                    <td class='text-center'>${lecturer.lecturer_race}</td>
                    <td>${lecturer.lecturer_phone_number}</td>
                    <td>${lecturer.lecturer_email}</td>
                    <td class="text-center">
                      <div class="row">
                        <div class="col-4 text-center">
                          <a href="./operation/lecturer/viewLecturer.php?id=${lecturer.lecturer_id}">
                            <i class="fa-solid fa-eye text-primary"></i>
                          </a>
                        </div>
                        <div class="col-4 text-center">
                          <a href="./operation/lecturer/editLecturer.php?id=${lecturer.lecturer_id}">
                            <i class="fa-solid fa-pencil text-success"></i>
                          </a>
                        </div>
                        <div class="col-4 text-center">
                          <a href="#" onclick="deleteLecturer('${lecturer.lecturer_id}', '${lecturer.lecturer_name}')">
                            <i class="fa-solid fa-trash text-danger"></i>
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                `);
            });
          } else {
            $('#lecturerTable tbody').append(`
                <tr>
                  <td colspan="7" class="text-center">No lecturers found</td>
                </tr>
              `);
          }
        },
        error: function(xhr, status, error) {
          console.error('Error searching lecturers:', error);
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