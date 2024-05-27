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
  <title>Edit Section</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../../styles/style.css">
</head>

<body>
  <form class="w-50 mx-auto rounded border border-secondary px-3 pt-2 pb-4 mt-4 position-relative"
    action="../../crud/section/editSectionOperation.php?id=<?php echo $_GET["id"] ?>" method="POST" autocomplete="off">
    <!-- CANCEL BUTTON -->
    <button type="button" onclick="handleCancel()"
      class="btn btn-secondary position-absolute end-0 me-3 mt-1">CANCEL</button>
    <!-- TITLE -->
    <h2>Edit section</h2>
    <hr>
    <?php 
      $section_id = $_GET['id'];

      $sql = "SELECT s.*, l.lecturer_name, c.course_name
        FROM section s 
        JOIN lecturer l ON s.lecturer_id = l.lecturer_id 
        JOIN course c ON s.course_code = c.course_code
        WHERE s.section_id = ?";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $section_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if($row = $result->fetch_assoc()) {
    ?>
    <!-- COURSE CODE -->
    <div class="d-flex align-items-center">
      <p class="m-0 me-2">Course code:</p>
      <select name="course-code" id="course-code-select" oninput="handleoninput()">
        <?php 
          $sql_courses = "SELECT course_code, course_name FROM course ORDER BY course_code";
          $result_courses = mysqli_query($conn, $sql_courses);

          if(mysqli_num_rows($result_courses) > 0) {
            while($rowOption = mysqli_fetch_assoc($result_courses)) {
              $courseCode = $rowOption['course_code'];
              $courseName = $rowOption['course_name'];
              $selected = ($courseCode == $row["course_code"]) ? 'selected' : '';
              echo "<option value='$courseCode' $selected>$courseCode $courseName</option>";
            }
            mysqli_free_result($result_courses);
          } else {
            echo "<option value='' disabled>No courses found</option>";
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
            oninput="handleoninput()" max="50" min="1" required id="sectionNumberInput"
            value="<?php echo $row["section_number"] ?>">
        </div>
        <!-- QUOTA -->
        <div class="col">
          <input type="number" class="form-control border border-secondary" name="section-quota"
            oninput="handleoninput()" min="1" max="100" required value="<?php echo $row["section_quota"] ?>">
        </div>
        <!-- TYPE -->
        <div class="col">
          <select name="section-type" id="section-type-select" class="w-100 h-100 rounded" required
            oninput="handleoninput()">
            <option value="A" <?php echo ($row["section_type"] == "A") ? 'selected' : ''; ?>>Tutorial</option>
            <option value="K" <?php echo ($row["section_type"] == "K") ? 'selected' : ''; ?>>Lecture</option>
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
            <option value="Sun" selected="<?php echo $row["section_day"] == "Sun" ? 'selected' : '' ?>">Sun</option>
            <option value="Mon" selected="<?php echo $row["section_day"] == "Mon" ? 'selected' : '' ?>">Mon</option>
            <option value="Tue" selected="<?php echo $row["section_day"] == "Tue" ? 'selected' : '' ?>">Tue</option>
            <option value="Wed" selected="<?php echo $row["section_day"] == "Wed" ? 'selected' : '' ?>">Wed</option>
            <option value="Thu" selected="<?php echo $row["section_day"] == "Thu" ? 'selected' : '' ?>">Thu</option>
          </select>
        </div>
        <!-- START TIME -->
        <div class="col">
          <input type="time" name="section-start-time" class="form-control border border-secondary" required
            oninput="handleoninput()" value="<?php echo $row["section_start_time"] ?>">
        </div>
        <!-- END TIME -->
        <div class="col">
          <input type="time" name="section-end-time" class="form-control border border-secondary" required
            oninput="handleoninput()" value="<?php echo $row["section_end_time"] ?>">
        </div>
      </div>
    </div>
    <!-- LOCATION -->
    <p class="mt-3 mb-1">Location:</p>
    <input type="text" name="section-location" class="form-control border border-secondary" maxlength="100" required
      oninput="handleoninput()" value="<?php echo $row["section_location"] ?>">
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
            class="form-control border border-secondary" oninput="handleoninput()"
            value="<?php echo $row["section_duration"] ?>">
        </div>
        <!-- LECTURER -->
        <div class="col">
          <select name="lecturer" id="lecturer-select" class="w-100 h-100 rounded" oninput="handleoninput()">
            <?php
              $sql = "SELECT lecturer_id, lecturer_name FROM lecturer ORDER BY lecturer_name";
              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                while ($lecturerRow = mysqli_fetch_assoc($result)) {
                  $lecturerId = $lecturerRow['lecturer_id'];
                  $lecturerName = $lecturerRow['lecturer_name'];
                  $selected = ($lecturerId == $row['lecturer_id']) ? 'selected' : '';

                  echo '<option value="' . $lecturerId . '" ' . $selected . '>' . $lecturerName . '</option>';
                }
              } else {
                echo '<option value="" disabled>No lecturers found</option>';
              }
            ?>
          </select>

        </div>
      </div>
    </div>
    <?php 
      }
      mysqli_close( $conn );
    ?>

    <!-- EDIT BUTTON -->
    <div class="text-center">
      <button class="btn btn-success block w-50 mx-auto mt-5" type="submit" name="edit" id="edit-button">EDIT</button>
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

  // check repeating section number
  $(document).ready(function() {
    $('#sectionNumberInput').on('input', function() {
      var sectionId = "<?php echo $_GET['id']; ?>";
      var sectionNumber = $(this).val().trim();
      var courseCode = $('#course-code-select').val();
      var type = $('#section-type-select').val();

      if (sectionNumber !== '') {
        $.ajax({
          url: 'checkSectionNumberEdit.php',
          method: 'POST',
          data: {
            sectionId: sectionId,
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

  // check repeating section number
  $(document).ready(function() {
    $('#section-type-select').on('change', function() {
      var sectionNumber = $('#sectionNumberInput').val().trim();
      var courseCode = $('#course-code-select').val();
      var type = $(this).val();
      var sectionId = <?php echo $_GET['id'] ?>

      if (sectionNumber !== '') {
        $.ajax({
          url: 'checkSectionNumberEdit.php',
          method: 'POST',
          data: {
            sectionId: sectionId,
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
  }
?>