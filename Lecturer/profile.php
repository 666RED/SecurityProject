<?php 
  session_start();

  if(!isset($_SESSION['lecturerID'])) {
    echo 'Please login first <br>';
    echo 'Click <a href="index.php">here<a/> to login';
  }else {
    include "db.php";

    $lecturerID = $_SESSION['lecturerID'];
    $sql = "SELECT * FROM lecturer WHERE lecturer_id = ? AND lecturer_archive = 0";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturerID);
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
  <link rel="stylesheet" href="./styles/style.css">
  <link rel="stylesheet" href="./styles/sidebar.css">
  <style>
    input[readonly] {
      cursor: not-allowed;
      background-color: #e9ecef; /* Optional: Adds a grey background to indicate non-editable */
    }
  </style>
</head>

<body>
  <!-- SIDEBAR -->
  <div class="bg-dark text-white sidebar">
      <a href="course.php" class="btn nav-btn text-white d-block text-start">Course</a>
      <a href="profile.php" class="btn nav-btn text-white d-block text-start selected">Profile</a>
      <a href="updatePassword.php" class ="btn nav-btn text-white d-block text-start">Update<br>Password</a>
      <a href="clearId.php" class="btn nav-btn text-white d-block text-start position-absolute w-100 bottom-0">Logout</a>
  </div>
  <form class="w-50 mx-auto rounded border border-secondary px-3 pt-2 pb-4 my-4 position-relative" method="POST"
    action="./operation/updateProfile.php?id=<?php echo $lecturerID ?>">
    
    <!-- TITLE -->
    <h2>Edit Profile</h2>
    <hr>
    <!-- LECTURER NAME -->
    <p class="mt-3 mb-1">Name:</p>
    <input type="text" class="form-control border border-secondary" name="name"
      value="<?php echo $row["lecturer_name"]?>" onchange="handleOnChange()" maxlength="50" readonly>
    <!-- GENDER & RACE -->
    <div class="mt-3">
      <div class="row">
        <!-- GENDER -->
        <div class="col-3 d-flex align-items-center">
          Gender:
          <select name="gender-select" class="ms-2" required onchange="handleOnChange()" disabled>
            <option value="Male" <?php echo $row["lecturer_gender"] == 'Male' ? 'selected' : '' ?>>Male
            </option>
            <option value="Female" <?php echo $row["lecturer_gender"] == 'Female' ? 'selected' : '' ?>>Female
            </option>
          </select>
        </div>
        <!-- RACE -->
        <div class="col-3">
          Race:
          <select name="race-select" class="ms-2" required onchange="handleOnChange()" disabled>
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
    <input type="email" class="form-control border border-secondary" name="email" readonly
      value="<?php echo $row["lecturer_email"]?>" onchange="handleOnChange()" placeholder="@uthm.edu.my"
      pattern=".+@uthm\.edu\.my" required maxlength="50" id="universityEmailInput">
    <span id="emailMessage"></span>
    <!-- PERSONAL EMAIL -->
    <p class="mt-3 mb-1">Personal email:</p>
    <input type="email" class="form-control border border-secondary" name="personal-email"
      value="<?php echo $row["lecturer_personal_email"]?>" onchange="handleOnChange()" maxlength="100">
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

  const handleCancel = (event, url) => {
    if (!discardChanges) {
      window.location.href = url;
      return;
    }

    const ans = window.confirm("Discard changes?");
    if (ans) {
      window.location.href = url;
    } else {
      event.preventDefault();
    }
  }

  document.querySelectorAll('.sidebar a').forEach(link => {
    link.addEventListener('click', function(event) {
      handleCancel(event, this.href);
    });
  });
  </script>
</body>

</html>

<?php 
    } else {
        echo "
        <h2>Lecturer data is unavailable</h2>
        <a href='../../lecturer.php'>Back</a>
      ";
    }
    mysqli_close($conn);
  }
?>