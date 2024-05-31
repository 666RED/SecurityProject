<?php 
  session_start();

  if(!isset($_SESSION['admin'])) {
    echo 'Please login first <br>';
    echo 'Click <a href="index.php">here<a/> to login';
  }else {
    include "../../db.php";

    $lecturerId = $_GET['id'];

    $sql = "SELECT * FROM lecturer WHERE lecturer_id = ? AND lecturer_archive = 0";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $lecturerId);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Lecturer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../../styles/style.css">
</head>

<body>
  <form class="w-50 mx-auto rounded border border-secondary px-3 pt-2 pb-4 my-4 position-relative" method="POST"
    action="../../crud/lecturer/editLecturerOperation.php?id=<?php echo $_GET['id'] ?>">
    <!-- CANCEL BUTTON -->
    <button type="button" onclick="handleCancel()"
      class="btn btn-secondary position-absolute end-0 me-3 mt-1">CANCEL</button>
    <!-- TITLE -->
    <h2>Edit lecturer</h2>
    <hr>
    <!-- LECTURER NAME -->
    <p class="mt-3 mb-1">Name:</p>
    <input type="text" class="form-control border border-secondary" name="name"
      value="<?php echo $row["lecturer_name"]?>" onchange="handleOnChange()" maxlength="50" required>
    <!-- GENDER & RACE -->
    <div class="mt-3">
      <div class="row">
        <!-- GENDER -->
        <div class="col-3 d-flex align-items-center">
          Gender:
          <select name="gender-select" class="ms-2" required onchange="handleOnChange()">
            <option value="Male" <?php echo $row["lecturer_gender"] == 'Male' ? 'selected' : '' ?>>Male
            </option>
            <option value="Female" <?php echo $row["lecturer_gender"] == 'Female' ? 'selected' : '' ?>>Female
            </option>
          </select>
        </div>
        <!-- RACE -->
        <div class="col-3">
          Race:
          <select name="race-select" class="ms-2" required onchange="handleOnChange()">
            <option value="Malay" <?php echo $row["lecturer_race"] == "Malay" ? 'selected' : '' ?>>Malay
            </option>
            <option value="Chinese" <?php echo $row["lecturer_race"] == "Chinese" ? 'selected' : '' ?>>
              Chinese</option>
            <option value="India" <?php echo $row["lecturer_race"] == "India" ? 'selected' : '' ?>>India
            </option>
            <option value="Other" <?php echo $row["lecturer_race"] == "Other" ? 'selected' : '' ?>>Other
            </option>
          </select>
        </div>
      </div>
    </div>
    <!-- PHONE NUMBER -->
    <p class="mt-3 mb-1">Phone number:</p>
    <input type="text" class="form-control border border-secondary" name="phone-number"
      value="<?php echo $row["lecturer_phone_number"]?>" onchange="handleOnChange()" required maxlength="11"
      minlength="9" pattern="[0-9]+" placeholder="e.g. 0118492758">
    <!-- EMAIL -->
    <p class="mt-3 mb-1">University email:</p>
    <input type="email" class="form-control border border-secondary" name="email"
      value="<?php echo $row["lecturer_email"]?>" onchange="handleOnChange()" placeholder="@uthm.edu.my"
      pattern=".+@uthm\.edu\.my" required maxlength="50" id="universityEmailInput">
    <span id="emailMessage"></span>
    <!-- PERSONAL EMAIL -->
    <p class="mt-3 mb-1">Personal email:</p>
    <input type="email" class="form-control border border-secondary" name="personal-email"
      value="<?php echo $row["lecturer_personal_email"]?>" onchange="handleOnChange()" onchange="handleOnChange()"
      maxlength="100">
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
      window.location.href = '../../lecturer.php';
      return;
    }

    const ans = window.confirm("Discard changes?");
    if (ans) {
      window.location.href = '../../lecturer.php';
    }
  }

  $(document).ready(function() {
    $('#universityEmailInput').on('input', function() {
      var universityEmail = $(this).val().trim();

      console.log(universityEmail);


      if (universityEmail !== '') {
        $.ajax({
          url: 'checkUniversityEmailEdit.php?id=<?php echo $_GET['id'] ?>', // Your PHP script to check email existence
          method: 'POST',
          data: {
            universityEmail: universityEmail
          },
          success: function(response) {
            if (response === 'exists') {
              $('#emailMessage').html('<span style="color: red;">University email already in use</span>');
              $('#edit-button').prop('disabled', true); // Disable form submit button
            } else {
              $('#emailMessage').html('');
              $('#edit-button').prop('disabled', false); // Enable form submit button
            }
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
      } else {
        $('#emailMessage').html('');
        $('#edit-button').prop('disabled', false); // Enable form submit button if field is empty
      }
    });
  });
  </script>
</body>

</html>

<?php 
    }else {
      echo "
        <h2>Lecturer data is unavailable</h2>
        <a href='../../lecturer.php'>Back</a>
      ";
    }
    mysqli_close( $conn );
  }
?>