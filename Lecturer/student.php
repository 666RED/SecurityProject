<?php 
  session_start();

  if(!isset($_SESSION['lecturerID'])) {
    echo 'Please login first <br>';
    echo 'Click <a href="index.php">here<a/> to login';
  }else {
    include "db.php";

    if (isset($_GET['student']) && isset($_GET['course_code']) && isset($_GET['section_number'])) {
      $studentMatricNumber = $_GET['student'];
      $course_code = $_GET['course_code'];
      $section_number = $_GET['section_number'];

      $sql = "SELECT * 
      FROM student_section ss
      JOIN student s ON s.student_matric_number = ss.student_matric_number
      JOIN course c ON c.course_code = ss.course_code
      WHERE ss.student_matric_number = ? AND ss.course_code = ? AND section_number = ? AND student_archive = 0";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssi", $studentMatricNumber, $course_code, $section_number);
      $stmt->execute();
      $result = $stmt->get_result();

      if($row = $result->fetch_assoc()) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $row["student_name"] ." " .$row["student_matric_number"] ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="styles/style.css">
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
    action="./operation/updateMark.php" method="POST"
    autocomplete="off">
    <!-- CANCEL BUTTON -->
    <button type="button" onclick="handleCancel()"
      class="btn btn-secondary position-absolute end-0 me-3 mt-1">CANCEL</button>
    <!-- TITLE -->
    <h2>Marking</h2>
    <hr>
    <!-- STUDENT NAME -->
    <p class="mt-3 mb-1">Name:</p>
    <input type="text" class="form-control border border-secondary" name="name" readonly
      value="<?php echo $row["student_name"] ?>">
    <!-- STUDENT MATRIC NUMBER & IC -->
    <div class="mt-3">
      <div class="row">
        <div class="col">
          Matric Number:
        </div>
        <div class="col">
          IC Number:
        </div>
      </div>
    </div>
    <!-- INPUT -->
    <div class="row">
      <div class="col">
        <input type="text" class="form-control border border-secondary" name="matric-number" readonly
          id="studentMatricNumberInput" value="<?php echo $row["student_matric_number"] ?>">
      </div>
      <div class="col">
        <input type="text" name="ic-number" class="form-control border border-secondary" id="icNumberInput" 
          value="<?php echo $row["student_IC"] ?>">
      </div>
    </div>
    <!-- Course code & Course Name -->
    <div class="mt-3">
      <div class="row">
        <div class="col">
          Course Code:
        </div>
        <div class="col">
          Course Name:
        </div>
        <div class="col">
          Section:
        </div>
      </div>
    </div>
    <!-- INPUT -->
    <div class="row">
      <div class="col">
        <input type="text" class="form-control border border-secondary" name="course-code" id="courseCodeInput" readonly
          value="<?php echo $row["course_code"] ?>">
      </div>
      <div class="col">
        <input type="text" name="course-name" class="form-control border border-secondary" id="courseNameInput" readonly
          value="<?php echo $row["course_name"] ?>">
      </div>
      <div class="col">
        <input type="text" name="section-name" class="form-control border border-secondary" id="sectionInput" readonly
          value="<?php echo $row["section_number"] ?>">
      </div>
    </div>
    <!-- Quiz & Assignment & Test -->
    <div class="mt-3">
      <!-- TITLE -->
      <div class="row">
        <div class="col">
          Quiz: (5m)
        </div>
        <div class="col">
          Assignment: (20m)
        </div>
        <div class="col">
          Test: (15m)
        </div>
        <div class="col">
          Project: (20m)
        </div>
      </div>
      <!-- INPUT -->
      <div class="row">
        <div class="col">
        <input type="number" name="quiz-mark" class="form-control border border-secondary" id="quizMarkInput" onchange="handleOnChange()"
          value="<?php echo $row["quiz_mark"] ?>">
        </div>
        <div class="col">
        <input type="number" name="assignment-mark" class="form-control border border-secondary" id="assignmentMarkInput" onchange="handleOnChange()"
          value="<?php echo $row["assignment_mark"] ?>">
        </div>
        <div class="col">
        <input type="number" name="test-mark" class="form-control border border-secondary" id="testMarkInput" onchange="handleOnChange()"
          value="<?php echo $row["test_mark"] ?>">
        </div>
        <div class="col">
        <input type="number" name="project-mark" class="form-control border border-secondary" id="projectMarkInput" onchange="handleOnChange()"
          value="<?php echo $row["project_mark"] ?>">
        </div>
      </div>
    </div>
    <!-- Coursework Mark & Final Test -->
    <div class="mt-3">
      <!-- TITLE -->
      <div class="row">
        <div class="col">
          Coursework mark: (60m)
        </div>
        <div class="col">
          Final Exam: (40m)
        </div>
      </div>
      <!-- INPUT -->
      <div class="row">
      <div class="col">
      <input type="number" name="coursework-mark" class="form-control border border-secondary" id="courseworkMarkDisplay" readonly
        value="">
      </div>
      <div class="col">
      <input type="number" name="Final-mark" class="form-control border border-secondary" id="FinalMarkInput" onchange="handleOnChange()"
        value="<?php echo $row["final_mark"] ?>">
      </div>
    </div>
    <!-- Total mark & Grade -->
    <div class="mt-3">
      <!-- TITLE -->
      <div class="row">
        <div class="col">
          Total mark: (100m)
        </div>
        <div class="col">
          Grade:
        </div>
      </div>
      <!-- INPUT -->
      <div class="row">
      <div class="col">
      <input type="text" name="total-mark" class="form-control border border-secondary" id="totalMarkDisplay" readonly
        value="">
      </div>
      <div class="col">
      <input type="text" name="grade" class="form-control border border-secondary" id="gradeDisplay" readonly
        value="<?php echo $row["course_grade"] ?>">
      </div>
    </div>

      <!-- EDIT BUTTON -->
      <div class="text-center">
        <button class="btn btn-success block w-50 mx-auto mt-5" type="submit" name="update" id="update-button">UPDATE</button>
      </div>
    </div>

  </form>
  <!-- JS SCRIPT -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
  function calculateCourseworkMark() {
    // Get the values from the input fields
    var quizMark = parseFloat(document.getElementById('quizMarkInput').value) || 0;
    var assignmentMark = parseFloat(document.getElementById('assignmentMarkInput').value) || 0;
    var testMark = parseFloat(document.getElementById('testMarkInput').value) || 0;
    var projectMark = parseFloat(document.getElementById('projectMarkInput').value) || 0;

    // Calculate the coursework mark
    var courseworkMark = quizMark + assignmentMark + testMark + projectMark;

    // Display the coursework mark
    document.getElementById('courseworkMarkDisplay').value = courseworkMark;

     // Calculate the total mark
     calculateTotalMark();
  }

  function calculateTotalMark() {
    // Get the values from the input fields
    var courseworkMark = parseFloat(document.getElementById('courseworkMarkDisplay').value) || 0;
    var finalMark = parseFloat(document.getElementById('FinalMarkInput').value) || 0;

    // Calculate the total mark
    var totalMark = courseworkMark + finalMark;

    // Display the total mark
    document.getElementById('totalMarkDisplay').value = totalMark;

    // Calculate and display the grade
    calculateGrade(totalMark);
  }

  function calculateGrade(totalMark) {
    var grade = document.getElementById('gradeDisplay').value;
    console.log("grade");
    if (totalMark >= 85 && totalMark <= 100) {
      grade = 'A+';
    } else if (totalMark >= 80 && totalMark < 85) {
      grade = 'A';
    } else if (totalMark >= 75 && totalMark < 80) {
      grade = 'A-';
    } else if (totalMark >= 70 && totalMark < 75) {
      grade = 'B+';
    } else if (totalMark >= 65 && totalMark < 70) {
      grade = 'B';
    } else if (totalMark >= 60 && totalMark < 65) {
      grade = 'B-';
    } else if (totalMark >= 55 && totalMark < 60) {
      grade = 'C+';
    } else if (totalMark >= 50 && totalMark < 55) {
      grade = 'C';
    } else if (totalMark >= 45 && totalMark < 50) {
      grade = 'C-';
    } else if (totalMark >= 40 && totalMark < 45) {
      grade = 'D';
    } else {
      grade = 'E';
    }

    // Display the grade
    document.getElementById('gradeDisplay').value = grade;
  }

  // Add event listeners to call calculateCourseworkMark whenever an input changes
  window.onload = function() {

    // Get the values from the input fields
    var quizMark = parseFloat(document.getElementById('quizMarkInput').value) || 0;
    var assignmentMark = parseFloat(document.getElementById('assignmentMarkInput').value) || 0;
    var testMark = parseFloat(document.getElementById('testMarkInput').value) || 0;
    var projectMark = parseFloat(document.getElementById('projectMarkInput').value) || 0;

    // Calculate the coursework mark
    var courseworkMark = quizMark + assignmentMark + testMark + projectMark;

    // Display the coursework mark
    document.getElementById('courseworkMarkDisplay').value = courseworkMark;

    // Calculate the total mark
    calculateTotalMark();

    document.getElementById('quizMarkInput').addEventListener('input', calculateCourseworkMark||calculateTotalMark);
    document.getElementById('assignmentMarkInput').addEventListener('input', calculateCourseworkMark);
    document.getElementById('testMarkInput').addEventListener('input', calculateCourseworkMark);
    document.getElementById('projectMarkInput').addEventListener('input', calculateCourseworkMark);
    document.getElementById('FinalMarkInput').addEventListener('input', calculateTotalMark);
    
  }
  
  let discardChanges = false;

  const handleOnChange = () => {
    discardChanges = true;
  }

  const handleCancel = () => {
    if (!discardChanges) {
      window.location.href = './section.php?course_code=<?php echo$course_code ?>&section_number=<?php echo $section_number?>';
      return;
    }

    const ans = window.confirm("Discard changes?");
    if (ans) {
      window.location.href = '../../student.php';
    }
  }

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
    }
    mysqli_close( $conn );
  }
?>