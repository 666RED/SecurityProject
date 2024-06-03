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
  <title>Update Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./styles/style.css">
  <link rel="stylesheet" href="./styles/sidebar.css">
</head>

<body>
  <!-- SIDEBAR -->
  <div class="bg-dark text-white sidebar">
      <a href="./course.php" class="btn nav-btn text-white d-block text-start">Course</a>
      <a href="./profile.php" class="btn nav-btn text-white d-block text-start">Profile</a>
      <a href="updatePassword.php" class ="btn nav-btn text-white d-block text-start selected">Update<br>Password</a>
      <a href="./clearId.php" class="btn nav-btn text-white d-block text-start position-absolute w-100 bottom-0">Logout</a>
  </div>
  <form class="w-50 mx-auto rounded border border-secondary px-3 pt-2 pb-4 my-4 position-relative" method="POST"
    action="./operation/updateNewPassword.php?id=<?php echo $lecturerID ?>">
    
    <!-- TITLE -->
    <h2>Update Password</h2>
    <hr>
    <!-- LECTURER NAME -->
    <p class="mt-3 mb-1">Old Password:</p>
    <input type="password" class="form-control border border-secondary" id="oldpassword-input" onchange="handleOnChange()"
        placeholder="At least 8 characters" name="oldpassword" minlength="8" required maxlength="50">
    <p class="mt-3 mb-1">New Password:</p>
    <input type="password" class="form-control border border-secondary" id="newpassword-input" onchange="handleOnChange()"
        placeholder="At least 8 characters" name="newpassword" minlength="8" required maxlength="50">
    <p class="mt-3 mb-1">Confirm New Password:</p>
    <input type="password" class="form-control border border-secondary" id="confirmpassword-input" onchange="handleOnChange()"
        placeholder="At least 8 characters" name="confirmnewpassword" minlength="8" required maxlength="50">
    <!-- UPDATE BUTTON -->
    <div class="text-center">
      <button class="btn btn-success block w-50 mx-auto mt-5" type="submit" name="update" id="update-button">UPDATE</button>
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