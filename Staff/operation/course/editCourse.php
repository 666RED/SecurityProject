<?php 
  session_start();

  if(!isset($_SESSION['admin'])) {
    echo 'Please login first <br>';
    echo 'Click <a href="index.php">here<a/> to login';
  }else {
    include '../../db.php';

    $id = $_GET['id'];

    $sql = "SELECT * FROM course WHERE course_code = '$id'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Course</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../../styles/style.css">
</head>

<body>
  <form class="w-50 mx-auto rounded border border-secondary px-2 pt-2 pb-4 mt-4 position-relative"
    action="../../crud/course/editCourseOperation.php?id=<?php echo $_GET['id'] ?>" method="POST">
    <!-- CANCEL BUTTON -->
    <button type="button" onclick="handleCancel()"
      class="btn btn-secondary position-absolute end-0 me-3 mt-1">CANCEL</button>
    <!-- TITLE -->
    <h2>Edit course</h2>
    <hr>
    <!-- COURSE CODE -->
    <p>Course code:</p>
    <input type="text" class="form-control border border-secondary" id="courseCodeInput"
      value="<?php echo $row["course_code"]?>" name="code" onchange="handleOnChange()">
    <span id="courseCodeMessage"></span>
    <!-- COURSE NAME -->
    <p class="mt-3">Course name:</p>
    <input type="text" class="form-control border border-secondary" required maxlength="100"
      value="<?php echo $row["course_name"]?>" onchange="handleOnChange()" name="name">
    <!-- CREDIT HOUR -->
    <p class="mt-3">Course credit hours:</p>
    <input type="number" class="form-control border border-secondary" min="0" max="4" required
      value="<?php echo $row["course_credit_hour"]?>" onchange="handleOnChange()" name="credit-hour">
    <!-- EDIT BUTTON -->
    <div class="text-center">
      <button class="btn btn-success block w-50 mx-auto mt-5" type="submit" name="edit" id="edit-button">EDIT</button>
    </div>
  </form>
  <!-- JS SCRIPT -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
  let discardChanges = false;

  const handleOnChange = () => {
    discardChanges = true;
  }

  const handleCancel = () => {
    if (!discardChanges) {
      window.location.href = '../../course.php';
      return;
    }

    const ans = window.confirm("Discard changes?");
    if (ans) {
      window.location.href = '../../course.php';
    }
  }

  $(document).ready(function() {
    $('#courseCodeInput').on('input', function() {
      var courseCode = $(this).val().trim();
      console.log('hello');


      if (courseCode !== '') {
        $.ajax({
          url: 'checkCourseCodeEdit.php?id=<?php echo $_GET['id'] ?>',
          method: 'POST',
          data: {
            course_code: courseCode
          },
          success: function(response) {
            if (response === 'exists') {
              $('#courseCodeMessage').html('<span style="color: red;">Course code already exists</span>');
              $('#edit-button').prop('disabled', true);
            } else {
              $('#courseCodeMessage').html('');
              $('#edit-button').prop('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#courseCodeMessage').html('');
        $('#edit-button').prop('disabled', false);
      }
    });
  });
  </script>
</body>

</html>

<?php 
  }
    }
    mysqli_close( $conn );
  }
?>