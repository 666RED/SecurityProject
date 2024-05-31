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
  <title>Add Student</title>
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
    action="../../crud/student/addStudentOperation.php" method="POST" autocomplete="off">
    <!-- CANCEL BUTTON -->
    <button type="button" onclick="handleCancel()"
      class="btn btn-secondary position-absolute end-0 me-3 mt-1">CANCEL</button>
    <!-- TITLE -->
    <h2>Add student</h2>
    <hr>
    <!-- STUDENT NAME -->
    <p class="mt-3 mb-1">Name:</p>
    <input type="text" class="form-control border border-secondary" name="name" onchange="handleOnChange()" required
      maxlength="50">
    <!-- STUDENT MATRIC NUMBER -->
    <p class="mt-3 mb-1">Matric number:</p>
    <input type="text" class="form-control border border-secondary" name="matric-number" onchange="handleOnChange()"
      required maxlength="8" id="studentMatricNumberInput">
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
            class="form-control border border-secondary" id="icNumberInput" placeholder="e.g. 012345016789">
        </div>
        <div class="col">
          <input type="date" required onchange="handleOnChange()" name="date-of-birth"
            class="form-control border border-secondary">
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
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div class="col">
          <select name="race-select" class="rounded w-100 py-2" required>
            <option value="Malay">Malay</option>
            <option value="Chinese">Chinese</option>
            <option value="India">India</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="col">
          <select name="nationality-select" class="rounded w-100 py-2" required>
            <option value="Malaysian">Malaysian</option>
            <option value="Non-Malaysian">Non-Malaysian</option>
          </select>
        </div>
      </div>
    </div>
    <!-- PHONE NUMBER -->
    <p class="mt-3 mb-1">Phone number:</p>
    <input type="text" class="form-control border border-secondary" name="phone-number" onchange="handleOnChange()"
      required maxlength="11" minlength="9" pattern="[0-9]+" placeholder="e.g. 0118492758">
    <!-- EMAIL -->
    <p class="mt-3 mb-1">Student email:</p>
    <input type="email" class="form-control border border-secondary" name="email" onchange="handleOnChange()"
      placeholder="@student.uthm.edu.my" pattern=".+@student\.uthm\.edu\.my" required maxlength="50" id="emailInput">
    <span id="emailMessage"></span>
    <!-- PERSONAL EMAIL -->
    <p class="mt-3 mb-1">Personal email (optional):</p>
    <input type="email" class="form-control border border-secondary" name="personal-email" onchange="handleOnChange()"
      maxlength="50">
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
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
        </div>
        <div class="col">
          <input type="number" placeholder="CGPA" required max="4.0" min="0.0" step="0.01"
            class="form-control border border-secondary" name="pre-u-result">
        </div>
      </div>
      <!-- PASSWORD -->
      <p class="mt-3 mb-1">Default password:</p>
      <div class="position-relative">
        <i class="fa-solid fa-eye icon" id="open-eye" onclick="handleViewPassword(1)"></i>
        <i class="fa-solid fa-eye-slash icon d-none" id="close-eye" onclick="handleViewPassword(0)"></i>
        <input type="password" class="form-control border border-secondary" id="password-input"
          placeholder="At least 8 characters" name="password" minlength="8" required maxlength="50">
      </div>
      <!-- ADD BUTTON -->
      <div class="text-center">
        <button class="btn btn-success block w-50 mx-auto mt-5" type="submit" name="add" id="add-button">ADD</button>
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

  const handleViewPassword = (value) => {
    if (value === 1) {
      document.getElementById("open-eye").classList.add("d-none")
      document.getElementById("close-eye").classList.remove("d-none")
      document.getElementById("close-eye").classList.add("d-block")
      document.getElementById("password-input").type = "text"
    } else {
      document.getElementById("open-eye").classList.remove("d-none")
      document.getElementById("open-eye").classList.add("d-block")
      document.getElementById("close-eye").classList.add("d-none")
      document.getElementById("password-input").type = "password"
    }
  }
  // CHECK MATRIC NUMBER
  $(document).ready(function() {
    $('#studentMatricNumberInput').on('input', function() {
      var studentMatricNumber = $(this).val().trim();

      if (studentMatricNumber !== '') {
        $.ajax({
          url: 'checkStudentMatricNumber.php',
          method: 'POST',
          data: {
            studentMatricNumber: studentMatricNumber
          },
          success: function(response) {
            if (response === 'exists') {
              $('#matricNumberMessage').html(
                '<span style="color: red;">Student matric number already in use</span>');
              $('#add-button').prop('disabled', true);
            } else {
              $('#matricNumberMessage').html('');
              $('#add-button').prop('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#matricNumberMessage').html('');
        $('#add-button').prop('disabled', false);
      }
    });
  });

  // CHECK IC NUMBER
  $(document).ready(function() {
    $('#icNumberInput').on('input', function() {
      var icNumber = $(this).val().trim();

      if (icNumber !== '') {
        $.ajax({
          url: 'checkIcNumber.php',
          method: 'POST',
          data: {
            icNumber: icNumber
          },
          success: function(response) {
            if (response === 'exists') {
              $('#icMessage').html(
                '<span style="color: red;">Student IC already in use</span>');
              $('#add-button').prop('disabled', true);
            } else {
              $('#icMessage').html('');
              $('#add-button').prop('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#icMessage').html('');
        $('#add-button').prop('disabled', false);
      }
    });
  });

  // CHECK STUDENT EMAIL
  $(document).ready(function() {
    $('#emailInput').on('input', function() {
      var studentEmail = $(this).val().trim();

      if (studentEmail !== '') {
        $.ajax({
          url: 'checkStudentEmail.php',
          method: 'POST',
          data: {
            studentEmail: studentEmail
          },
          success: function(response) {
            if (response === 'exists') {
              $('#emailMessage').html(
                '<span style="color: red;">Student email already in use</span>');
              $('#add-button').prop('disabled', true);
            } else {
              $('#emailMessage').html('');
              $('#add-button').prop('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#emailMessage').html('');
        $('#add-button').prop('disabled', false);
      }
    });
  });
  </script>
</body>

</html>

<?php 
  }
?>