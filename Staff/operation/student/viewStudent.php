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
  <title>View Student</title>
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

</body>
<form class="w-50 mx-auto rounded border border-secondary px-3 pt-2 pb-4 my-4 position-relative">
  <!-- TITLE -->
  <h2>View student</h2>
  <hr>
  <!-- STUDENT NAME -->
  <p class="mt-3 mb-1">Name:</p>
  <input type="text" class="form-control border border-secondary" value="<?php echo $row["student_name"] ?>" readonly>
  <!-- STUDENT MATRIC NUMBER -->
  <p class="mt-3 mb-1">Matric number:</p>
  <input type="text" class="form-control border border-secondary" value="<?php echo $row["student_matric_number"] ?>"
    readonly>
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
        <input type="text" class="form-control border border-secondary" value="<?php echo $row["student_IC"] ?>"
          readonly>
      </div>
      <div class="col">
        <input type="type" class="form-control border border-secondary" value="<?php echo $row["student_DOB"] ?>"
          readonly>
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
          <input type="text" class="form-control border border-secondary" value="<?php echo $row["student_gender"] ?>"
            readonly>
        </div>
        <div class="col">
          <input type="text" class="form-control border border-secondary" value="<?php echo $row["student_race"] ?>"
            readonly>
        </div>
        <div class="col">
          <input type="text" class="form-control border border-secondary"
            value="<?php echo $row["student_nationality"] ?>" readonly>
        </div>
      </div>
      <!-- PHONE NUMBER -->
      <p class="mt-3 mb-1">Phone number:</p>
      <input type="text" class="form-control border border-secondary" readonly
        value="<?php echo $row["student_phone_number"] ?>">
    </div>
    <!-- EMAIL -->
    <p class="mt-3 mb-1">Student email:</p>
    <input type="email" class="form-control border border-secondary" readonly
      value="<?php echo $row["student_student_email"] ?>">
    <!-- PERSONAL EMAIL -->
    <p class="mt-3 mb-1">Personal email:</p>
    <input type="email" class="form-control border border-secondary" readonly
      value="<?php echo $row["student_personal_email"] ?>">
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
          <input type="text" class="form-control border border-secondary" readonly
            value="<?php echo $row["student_muet_band"] ?>">
        </div>
        <div class="col">
          <input type="number" class="form-control border border-secondary" readonly
            value="<?php echo $row["student_pre_university_result"] ?>">
        </div>
      </div>
    </div>
    <!-- BACK BUTTON -->
    <div class="text-center">
      <button class="btn btn-secondary block w-50 mx-auto mt-4" type="button" name="back" id="back-button"
        onclick="window.location.href = '../../student.php'">BACK</button>
    </div>
</form>

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