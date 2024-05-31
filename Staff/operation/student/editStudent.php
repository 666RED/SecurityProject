<?php 
  session_start();

  if(!isset($_SESSION['admin'])) {
    echo 'Please login first <br>';
    echo 'Click <a href="index.php">here<a/> to login';
  }else {
    include "../../db.php";

    $studentMatricNumber = $_GET['matricNumber'];

    $sql = "SELECT * FROM student WHERE student_matric_number = ? AND student_archive = 0";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $studentMatricNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Student</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../../styles/style.css">
  <style>
  .icon {
    position: absolute;
    cursor: pointer;
    right: 8px;
    top: 10px;
    font-size: 18px;
  }

  .icon:hover {
    color: blue;
  }
  </style>
</head>


<body>
  <form class="w-50 mx-auto rounded border border-secondary px-3 pt-2 pb-4 my-4 position-relative"
    action="../../crud/student/editStudentOperation.php?matricNumber=<?php echo $_GET["matricNumber"] ?>" method="POST"
    autocomplete="off">
    <!-- CANCEL BUTTON -->
    <button type="button" onclick="handleCancel()"
      class="btn btn-secondary position-absolute end-0 me-3 mt-1">CANCEL</button>
    <!-- TITLE -->
    <h2>Edit student</h2>
    <hr>
    <!-- STUDENT NAME -->
    <p class="mt-3 mb-1">Name:</p>
    <input type="text" class="form-control border border-secondary" name="name" onchange="handleOnChange()" required
      maxlength="50" value="<?php echo $row["student_name"] ?>">
    <!-- STUDENT MATRIC NUMBER -->
    <p class="mt-3 mb-1">Matric number:</p>
    <input type="text" class="form-control border border-secondary" name="matric-number" onchange="handleOnChange()"
      required maxlength="8" id="studentMatricNumberInput" value="<?php echo $row["student_matric_number"] ?>">
    <span id="matricNumberMessage"></span>
    <!-- IC & DOB -->
    <div class="mt-3">
      <!-- TITLE -->
      <div class="row">
        <div class="col">
          IC number:
        </div>
        <div class="col">
          Date of birth
        </div>
      </div>
      <!-- INPUT -->
      <div class="row">
        <div class="col">
          <input type="text" required onchange="handleOnChange()" maxlength="20" name="ic-number"
            class="form-control border border-secondary" id="icNumberInput" placeholder="e.g. 012345016789"
            value="<?php echo $row["student_IC"] ?>">
        </div>
        <div class="col">
          <input type="date" required onchange="handleOnChange()" name="date-of-birth"
            class="form-control border border-secondary" value="<?php echo $row["student_DOB"] ?>">
        </div>
      </div>
      <!-- ERROR MESSAGE -->
      <div class="row">
        <div class="col-6">
          <span id="icMessage"></span>
        </div>
      </div>
    </div>
    <!-- GENDER & RACE & NATIONALITY -->
    <div class="mt-3">
      <!-- TITLE -->
      <div class="row">
        <div class="col">
          Gender:
        </div>
        <div class="col">
          Race:
        </div>
        <div class="col">
          Nationality:
        </div>
      </div>
      <!-- INPUT -->
      <div class="row">
        <div class="col">
          <select name="gender-select" class="rounded w-100 py-2" required>
            <option value="Male" <?php echo $row["student_gender"] == "Male" ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?php echo $row["student_gender"] == "Female" ? 'selected' : '' ?>>Female</option>
          </select>
        </div>
        <div class="col">
          <select name="race-select" class="rounded w-100 py-2" required>
            <option value="Malay" <?php echo $row["student_race"] == "Malay" ? 'selected' : '' ?>>Malay</option>
            <option value="Chinese" <?php echo $row["student_race"] == "Chinese" ? 'selected' : '' ?>>Chinese</option>
            <option value="India" <?php echo $row["student_race"] == "India" ? 'selected' : '' ?>>India</option>
            <option value="Other" <?php echo $row["student_race"] == "Other" ? 'selected' : '' ?>>Other</option>
          </select>
        </div>
        <div class="col">
          <select name="nationality-select" class="rounded w-100 py-2" required>
            <option value="Malaysian" <?php echo $row["student_nationality"] == "Malaysian" ? 'selected' : '' ?>>
              Malaysian
            </option>
            <option value="Non-Malaysian"
              <?php echo $row["student_nationality"] == "Non-Malaysian" ? 'selected' : '' ?>>
              Non-Malaysian</option>
          </select>
        </div>
      </div>
    </div>
    <!-- PHONE NUMBER -->
    <p class="mt-3 mb-1">Phone number:</p>
    <input type="text" class="form-control border border-secondary" name="phone-number" onchange="handleOnChange()"
      required maxlength="11" minlength="9" pattern="[0-9]+" placeholder="e.g. 0118492758"
      value="<?php echo $row["student_phone_number"] ?>">
    <!-- EMAIL -->
    <p class="mt-3 mb-1">Student email:</p>
    <input type="email" class="form-control border border-secondary" name="email" onchange="handleOnChange()"
      placeholder="@student.uthm.edu.my" pattern=".+@student\.uthm\.edu\.my" required maxlength="50" id="emailInput"
      value="<?php echo $row["student_student_email"] ?>">
    <span id="emailMessage"></span>
    <!-- PERSONAL EMAIL -->
    <p class="mt-3 mb-1">Personal email (optional):</p>
    <input type="email" class="form-control border border-secondary" name="personal-email" onchange="handleOnChange()"
      maxlength="50" value="<?php echo $row["student_personal_email"] ?>">
    <!-- MUET BAND & PRE U RESULT -->
    <div class="mt-3">
      <!-- TITLE -->
      <div class="row">
        <div class="col">
          Muet band:
        </div>
        <div class="col">
          Pre university result:
        </div>
      </div>
      <!-- INPUT -->
      <div class="row">
        <div class="col">
          <select name="muet-band-select" class="border border-secondary rounded w-100 py-2" required>
            <option value="1" <?php echo $row["student_muet_band"] == "1" ? 'selected': '' ?>>1</option>
            <option value="2" <?php echo $row["student_muet_band"] == "2" ? 'selected': '' ?>>2</option>
            <option value="3" <?php echo $row["student_muet_band"] == "3" ? 'selected': '' ?>>3</option>
            <option value="4" <?php echo $row["student_muet_band"] == "4" ? 'selected': '' ?>>4</option>
            <option value="5" <?php echo $row["student_muet_band"] == "5" ? 'selected': '' ?>>5</option>
            <option value="6" <?php echo $row["student_muet_band"] == "6" ? 'selected': '' ?>>6</option>
          </select>
        </div>
        <div class="col">
          <input type="number" placeholder="CGPA" required max="4.0" min="0.0" step="0.01"
            class="form-control border border-secondary" name="pre-u-result"
            value="<?php echo $row["student_pre_university_result"] ?>">
        </div>
      </div>
      <!-- EDIT BUTTON -->
      <div class="text-center">
        <button class="btn btn-success block w-50 mx-auto mt-5" type="submit" name="edit" id="edit-button">EDIT</button>
      </div>
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
      window.location.href = '../../student.php';
      return;
    }

    const ans = window.confirm("Discard changes?");
    if (ans) {
      window.location.href = '../../student.php';
    }
  }

  // CHECK MATRIC NUMBER
  $(document).ready(function() {
    $('#studentMatricNumberInput').on('input', function() {
      var studentMatricNumber = $(this).val().trim();

      if (studentMatricNumber !== '') {
        $.ajax({
          url: "checkStudentMatricNumberEdit.php?matricNumber=<?php echo $_GET["matricNumber"] ?>",
          method: 'POST',
          data: {
            studentMatricNumber: studentMatricNumber
          },
          success: function(response) {
            if (response === 'exists') {
              $('#matricNumberMessage').html(
                '<span style="color: red;">Student matric number already in use</span>');
              $('#edit-button').prop('disabled', true);
            } else {
              $('#matricNumberMessage').html('');
              $('#edit-button').prop('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#matricNumberMessage').html('');
        $('#edit-button').prop('disabled', false);
      }
    });
  });

  // CHECK IC NUMBER
  $(document).ready(function() {
    $('#icNumberInput').on('input', function() {
      var icNumber = $(this).val().trim();

      if (icNumber !== '') {
        $.ajax({
          url: 'checkIcNumberEdit.php?matricNumber=<?php echo $_GET["matricNumber"] ?>',
          method: 'POST',
          data: {
            icNumber: icNumber
          },
          success: function(response) {
            if (response === 'exists') {
              $('#icMessage').html(
                '<span style="color: red;">Student IC already in use</span>');
              $('#edit-button').prop('disabled', true);
            } else {
              $('#icMessage').html('');
              $('#edit-button').prop('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#icMessage').html('');
        $('#edit-button').prop('disabled', false);
      }
    });
  });

  // CHECK STUDENT EMAIL
  $(document).ready(function() {
    $('#emailInput').on('input', function() {
      var studentEmail = $(this).val().trim();

      if (studentEmail !== '') {
        $.ajax({
          url: 'checkStudentEmailEdit.php?matricNumber=<?php echo $_GET["matricNumber"] ?>',
          method: 'POST',
          data: {
            studentEmail: studentEmail
          },
          success: function(response) {
            if (response === 'exists') {
              $('#emailMessage').html(
                '<span style="color: red;">Student email already in use</span>');
              $('#edit-button').prop('disabled', true);
            } else {
              $('#emailMessage').html('');
              $('#edit-button').prop('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#emailMessage').html('');
        $('#edit-button').prop('disabled', false);
      }
    });
  });
  </script>
</body>

</html>

<?php 
    }else {
      echo "
        <h2>Student data is unavailable</h2>
        <a href='../../student.php'>Back</a>
      ";
    }
    mysqli_close( $conn );
  }
?>