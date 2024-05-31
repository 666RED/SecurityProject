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
  <title>View Lecturer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../../styles/style.css">
  <style>
  input,
  select {
    cursor: not-allowed;
  }
  </style>
</head>

<body>
  <form class="w-50 mx-auto rounded border border-secondary px-3 pt-2 pb-4 my-4 position-relative">
    <!-- TITLE -->
    <h2>View lecturer</h2>
    <hr>
    <!-- LECTURER NAME -->
    <p class="mt-3 mb-1">Name:</p>
    <input type="text" class="form-control border border-secondary" name="name"
      value="<?php echo $row["lecturer_name"]?>" readonly>
    <!-- GENDER & RACE -->
    <div class="mt-3">
      <div class="row">
        <div class="col">
          <p class="mb-1">Gender:</p>
        </div>
        <div class="col">
          <p class="mb-1">Race:</p>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="text" class="form-control border border-secondary" value="<?php echo $row["lecturer_gender"]?>"
            readonly>
        </div>
        <div class="col">
          <input type="text" class="form-control border border-secondary" value="<?php echo $row["lecturer_race"]?>"
            readonly>
        </div>
      </div>
    </div>
    <!-- PHONE NUMBER -->
    <p class="mt-3 mb-1">Phone number:</p>
    <input type="text" class="form-control border border-secondary" name="phone-number"
      value="<?php echo $row["lecturer_phone_number"]?>" readonly>
    <!-- EMAIL -->
    <p class="mt-3 mb-1">University email:</p>
    <input type="email" class="form-control border border-secondary" name="email"
      value="<?php echo $row["lecturer_email"]?>" readonly>
    <!-- PERSONAL EMAIL -->
    <p class="mt-3 mb-1">Personal email:</p>
    <input type="email" class="form-control border border-secondary" name="personal-email"
      value="<?php echo $row["lecturer_personal_email"]?>" readonly>
    <!-- BACK BUTTON -->
    <div class="text-center">
      <button class="btn btn-secondary block w-50 mx-auto mt-4" type="button" name="back" id="back-button"
        onclick="window.location.href = '../../lecturer.php'">BACK</button>
    </div>
  </form>
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