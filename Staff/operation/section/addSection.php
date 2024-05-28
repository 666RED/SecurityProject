<?php 
  session_start();

  if(!isset($_SESSION['admin'])) {
    echo 'Please login first <br>';
    echo 'Click <a href="index.php">here<a/> to login';
  }else {
    include '../../db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Section</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../../styles/style.css">
</head>

<body>
  <form class="w-50 mx-auto rounded border border-secondary px-3 pt-2 pb-4 mt-4 position-relative"
    action="../../crud/section/addSectionOperation.php" method="POST" autocomplete="off">
    <!-- CANCEL BUTTON -->
    <button type="button" onclick="handleCancel()"
      class="btn btn-secondary position-absolute end-0 me-3 mt-1">CANCEL</button>
    <!-- TITLE -->
    <h2>Add section</h2>
    <hr>
    <!-- COURSE CODE -->
    <div class="d-flex align-items-center">
      <p class="m-0 me-2">Course code:</p>
      <select name="course-code" id="course-code-select" oninput="handleoninput()">
        <?php 
          $sql = "SELECT course_code, course_name FROM course WHERE course_archive = 0 ORDER BY course_code";

          $result = mysqli_query($conn, $sql);

          if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
              $courseCode = $row['course_code'];
              $courseName = $row['course_name'];
              echo "<option value='$courseCode'>$courseCode $courseName</option>";
            }
            mysqli_free_result($result);
          } else {
            echo "No courses found";
          } 
        ?>
      </select>
    </div>
    <!-- SECTION NUMBER & QUOTA & LOCATION & TYPE -->
    <div class="mt-3">
      <!-- TITLE -->
      <div class="row">
        <div class="col">
          <p class="mb-1">Section number:</p>
        </div>
        <div class="col">
          <p class="mb-1">Quota:</p>
        </div>
        <div class="col">
          <p class="mb-1">Type:</p>
        </div>
      </div>
      <!-- INPUT -->
      <div class="row">
        <div class="col">
          <!-- SECTION NUMBER -->
          <input type="number" class="form-control border border-secondary" name="section-number"
            oninput="handleoninput()" max="50" min="1" required id="sectionNumberInput">
        </div>
        <!-- QUOTA -->
        <div class="col">
          <input type="number" class="form-control border border-secondary" name="section-quota"
            oninput="handleoninput()" min="1" max="100" required>
        </div>
        <!-- TYPE -->
        <div class="col">
          <select name="section-type" id="section-type-select" class="w-100 h-100 rounded" required
            oninput="handleoninput()">
            <option value="A">Tutorial</option>
            <option value="K">Lecture</option>
          </select>
        </div>
      </div>
      <div class="row">
        <span class="col-4" id="sectionNumberMessage"></span>
      </div>
    </div>
    <!-- DATE & TIME -->
    <div class="mt-3">
      <!-- TITLE -->
      <div class="row">
        <div class="col">
          <p class="mb-1">Day:</p>
        </div>
        <div class="col">
          <p class="mb-1">Start time:</p>
        </div>
        <div class="col">
          <p class="mb-1">End time:</p>
        </div>
      </div>
      <!-- INPUT -->
      <div class="row">
        <!-- DAY -->
        <div class="col">
          <select name="section-day" id="sectionDaySelect" class="w-100 h-100 rounded" required
            oninput="handleoninput()">
            <option value="Sun">Sun</option>
            <option value="Mon">Mon</option>
            <option value="Tue">Tue</option>
            <option value="Wed">Wed</option>
            <option value="Thu">Thu</option>
          </select>
        </div>
        <!-- START TIME -->
        <div class="col">
          <input type="time" name="section-start-time" class="form-control border border-secondary" required
            oninput="handleoninput()">
        </div>
        <!-- END TIME -->
        <div class="col">
          <input type="time" name="section-end-time" class="form-control border border-secondary" required
            oninput="handleoninput()">
        </div>
      </div>
    </div>
    <!-- LOCATION -->
    <p class="mt-3 mb-1">Location:</p>
    <input type="text" name="section-location" class="form-control border border-secondary" maxlength="100" required
      oninput="handleoninput()">
    <!-- DURATION AND LECTURER -->
    <div class="mt-3">
      <!-- TITLE -->
      <div class="row">
        <div class="col">
          Duration:
        </div>
        <div class="col">
          Lecturer:
        </div>
      </div>
      <!-- INPUT -->
      <div class="row">
        <div class="col">
          <!-- DURATION -->
          <input type="number" min="1" max="4" required name="section-duration"
            class="form-control border border-secondary" oninput="handleoninput()">
        </div>
        <!-- LECTURER -->
        <div class="col">
          <select name="lecturer" id="lecturer-select" class="w-100 h-100 rounded" oninput="handleoninput()">
            <?php
              $sql = "SELECT lecturer_id, lecturer_name FROM lecturer WHERE lecturer_archive = 0 ORDER BY lecturer_name";
              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="' . $row['lecturer_id'] . '">' . $row['lecturer_name'] . '</option>';
                }
              } else {
                echo '<p>No lecturers found</p>';
              }
            ?>
          </select>
        </div>
      </div>
    </div>

    <!-- ADD BUTTON -->
    <div class="text-center">
      <button class="btn btn-success block w-50 mx-auto mt-5" type="submit" name="add" id="add-button">ADD</button>
    </div>
  </form>

  <!-- JS SCRIPT -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
  let discardChanges = false;

  const handleoninput = () => {
    discardChanges = true;
  }

  const handleCancel = () => {
    if (!discardChanges) {
      window.location.href = '../../section.php';
      return;
    }

    const ans = window.confirm("Discard changes?");
    if (ans) {
      window.location.href = '../../section.php';
    }
  }

  // check repeating section number (section_number)
  $(document).ready(function() {
    $('#sectionNumberInput').on('input', function() {
      var sectionNumber = $(this).val().trim();
      var courseCode = $('#course-code-select').val();
      var type = $('#section-type-select').val();

      if (sectionNumber !== '') {
        $.ajax({
          url: 'checkSectionNumber.php',
          method: 'POST',
          data: {
            sectionNumber: sectionNumber,
            courseCode: courseCode,
            type: type
          },
          success: function(response) {
            if (response === 'exists') {
              $('#sectionNumberMessage').html(
                '<span style="color: red;">Section number already exists</span>');
              $('#add-button').prop('disabled', true);
            } else {
              $('#sectionNumberMessage').html('');
              $('#add-button').prop('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#sectionNumberMessage').html('');
        $('#add-button').prop('disabled', false);
      }
    });
  });

  // check repeating section number (section_type)
  $(document).ready(function() {
    $('#section-type-select').on('change', function() {
      var sectionNumber = $('#sectionNumberInput').val().trim();
      var courseCode = $('#course-code-select').val();
      var type = $(this).val();

      if (sectionNumber !== '') {
        $.ajax({
          url: 'checkSectionNumber.php',
          method: 'POST',
          data: {
            sectionNumber: sectionNumber,
            courseCode: courseCode,
            type: type
          },
          success: function(response) {
            if (response === 'exists') {
              $('#sectionNumberMessage').html(
                '<span style="color: red;">Section number already exists</span>');
              $('#add-button').prop('disabled', true);
            } else {
              $('#sectionNumberMessage').html('');
              $('#add-button').prop('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#sectionNumberMessage').html('');
        $('#add-button').prop('disabled', false);
      }
    });

    $('#section-type-select').change();
  });

  // check repeating section number (course_code)
  $(document).ready(function() {
    $('#course-code-select').on('change', function() {
      var sectionNumber = $('#sectionNumberInput').val().trim();
      var courseCode = $('#course-code-select').val();
      var type = $('#section-type-select').val();

      if (sectionNumber !== '') {
        $.ajax({
          url: 'checkSectionNumber.php',
          method: 'POST',
          data: {
            sectionNumber: sectionNumber,
            courseCode: courseCode,
            type: type
          },
          success: function(response) {
            if (response === 'exists') {
              $('#sectionNumberMessage').html(
                '<span style="color: red;">Section number already exists</span>');
              $('#add-button').prop('disabled', true);
            } else {
              $('#sectionNumberMessage').html('');
              $('#add-button').prop('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#sectionNumberMessage').html('');
        $('#add-button').prop('disabled', false);
      }
    });

    $('#section-type-select').change();
  });
  </script>
</body>

</html>

<?php 
  mysqli_close( $conn );
  }
?>