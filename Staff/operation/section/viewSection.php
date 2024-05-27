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
  <title>View Section</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../../styles/style.css">
</head>

<body>
  <form class="w-50 mx-auto rounded border border-secondary px-3 pt-2 pb-4 mt-4 position-relative">
    <!-- TITLE -->
    <h2>Add section</h2>
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
      <p style="width: 130px" class="m-0">Course code:</p>
      <input type="text" value="<?php echo $row["course_code"] . $row["course_name"]?>"
        class="form-control border border-secondary" readonly>
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
            value="<?php echo $row["section_number"] ?>" readonly>
        </div>
        <!-- QUOTA -->
        <div class="col">
          <input type="number" class="form-control border border-secondary" name="section-quota"
            value="<?php echo $row["section_quota"] ?>" readonly>
        </div>
        <!-- TYPE -->
        <div class="col">
          <input type="text" class="form-control border border-secondary" name="section-type"
            value="<?php echo $row["section_type"] === 'A' ? 'Tutorial': 'Lecture'?>" readonly>
        </div>
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
          <input type="text" class="form-control border border-secondary" name="section-day"
            value="<?php echo $row["section_day"] ?>" readonly>
        </div>
        <!-- START TIME -->
        <div class="col">
          <input type="time" name="section-start-time" class="form-control border border-secondary" readonly
            value="<?php echo $row["section_start_time"] ?>">
        </div>
        <!-- END TIME -->
        <div class="col">
          <input type="time" name="section-end-time" class="form-control border border-secondary" readonly
            value="<?php echo $row["section_end_time"] ?>">
        </div>
      </div>
    </div>
    <!-- LOCATION -->
    <p class="mt-3 mb-1">Location:</p>
    <input type="text" name="section-location" class="form-control border border-secondary" readonly
      value="<?php echo $row["section_location"] ?>">
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
          <input type="number" readonly name="section-duration" class="form-control border border-secondary"
            value="<?php echo $row["section_duration"] ?>">
        </div>
        <!-- LECTURER -->
        <div class="col">
          <input type="text" readonly name="lecturer-name" class="form-control border border-secondary"
            value="<?php echo $row["lecturer_name"] ?>">
        </div>
      </div>
    </div>
    <?php 
      }
      mysqli_close( $conn );
    ?>
    <!-- BACK BUTTON -->
    <div class="text-center">
      <button class="btn btn-secondary block w-50 mx-auto mt-5" type="button" name="back" id="back-button"
        onclick="window.location.href = '../../section.php'">BACK</button>
    </div>

  </form>
</body>

</html>
<?php 
  }
?>