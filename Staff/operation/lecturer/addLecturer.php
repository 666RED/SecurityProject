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
  <title>Add Lecturer</title>
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
    action="../../crud/lecturer/addLecturerOperation.php" method="POST" autocomplete="off">
    <!-- CANCEL BUTTON -->
    <button type="button" onclick="handleCancel()"
      class="btn btn-secondary position-absolute end-0 me-3 mt-1">CANCEL</button>
    <!-- TITLE -->
    <h2>Add lecturer</h2>
    <hr>
    <!-- LECTURER NAME -->
    <p class="mt-3 mb-1">Name:</p>
    <input type="text" class="form-control border border-secondary" name="name" onchange="handleOnChange()" required
      maxlength="50">
    <!-- GENDER & RACE -->
    <div class="mt-3">
      <div class="row">
        <!-- GENDER -->
        <div class="col-3 d-flex align-items-center">
          Gender:
          <select name="gender-select" class="ms-2" required onchange="handleOnChange()">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <!-- RACE -->
        <div class="col-3">
          Race:
          <select name="race-select" class="ms-2" required onchange="handleOnChange()">
            <option value="Malay">Malay</option>
            <option value="Chinese">Chinese</option>
            <option value="India">India</option>
            <option value="Other">Other</option>
          </select>
        </div>
      </div>
    </div>
    <!-- PHONE NUMBER -->
    <p class="mt-3 mb-1">Phone number:</p>
    <input type="text" class="form-control border border-secondary" name="phone-number" onchange="handleOnChange()"
      required maxlength="11" minlength="9" pattern="[0-9]+" placeholder="e.g. 0118492758">
    <!-- EMAIL -->
    <p class="mt-3 mb-1">University email:</p>
    <input type="email" class="form-control border border-secondary" name="email" onchange="handleOnChange()"
      placeholder="@uthm.edu.my" pattern=".+@uthm\.edu\.my" required maxlength="50" id="universityEmailInput">
    <span id="emailMessage"></span>
    <!-- PERSONAL EMAIL -->
    <p class="mt-3 mb-1">Personal email (optional):</p>
    <input type="email" class="form-control border border-secondary" name="personal-email" onchange="handleOnChange()"
      maxlength="50">
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
      window.location.href = '../../lecturer.php';
      return;
    }

    const ans = window.confirm("Discard changes?");
    if (ans) {
      window.location.href = '../../lecturer.php';
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

  $(document).ready(function() {
    $('#universityEmailInput').on('input', function() {
      var universityEmail = $(this).val().trim();

      if (universityEmail !== '') {
        $.ajax({
          url: 'checkUniversityEmail.php', // Your PHP script to check email existence
          method: 'POST',
          data: {
            universityEmail: universityEmail
          },
          success: function(response) {
            if (response === 'exists') {
              $('#emailMessage').html('<span style="color: red;">University email already in use</span>');
              $('#add-button').prop('disabled', true); // Disable form submit button
            } else {
              $('#emailMessage').html('');
              $('#add-button').prop('disabled', false); // Enable form submit button
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#emailMessage').html('');
        $('#add-button').prop('disabled', false); // Enable form submit button if field is empty
      }
    });
  });
  </script>
</body>

</html>

<?php 
  }
?>