<?php
require 'database.php';

session_start();

if (!isset($_SESSION['student_matric_number'])) {
    header('Location: index.php');
    exit();
}

$student_matric_number = $_SESSION['student_matric_number']; // Assuming the student matric number is stored in session

$max_attempts = 2;
$attempt_window = '15 MINUTE'; // Time window for rate limiting

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enroll'])) {
    $course_code = $_POST['course_code'];
    $section_number = $_POST['section_number'];

    if (isRateLimited($student_matric_number, $max_attempts, $attempt_window, $conn)) {
        header('Location: error.php');
        exit();
    } else {
        // Fetch the lecturer_id for the selected section
        $sql_lecturer = "SELECT lecturer_id FROM section WHERE course_code=? AND section_number=?";
        $stmt_lecturer = $conn->prepare($sql_lecturer);
        $stmt_lecturer->bind_param('ss', $course_code, $section_number);
        $stmt_lecturer->execute();
        $result_lecturer = $stmt_lecturer->get_result();

        if ($result_lecturer->num_rows > 0) {
            $lecturer = $result_lecturer->fetch_assoc();
            $lecturer_id = $lecturer['lecturer_id'];

            // Check if the student is already enrolled in the course
            $sql_check = "SELECT * FROM student_section WHERE student_matric_number = ? AND course_code = ? AND section_number = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param('sss', $student_matric_number, $course_code, $section_number);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                $error = "You are already enrolled in this course.";
            } else {
                // Enroll the student in the course
                $sql = "INSERT INTO student_section (student_matric_number, course_code, section_number, lecturer_id, enrollment_date) VALUES (?, ?, ?, ?, CURDATE())";
                $stmt_enroll = $conn->prepare($sql);
                $stmt_enroll->bind_param('ssss', $student_matric_number, $course_code, $section_number, $lecturer_id);

                if ($stmt_enroll->execute()) {
                    logEnrollmentAttempt($student_matric_number, $conn);
                    $success = "Course enrolled successfully";
                } else {
                    $error = "Error: " . $stmt_enroll->error;
                }
            }
        } else {
            $error = "Section not found.";
        }
    }
}

$search_term = '';
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
}

// Fetch courses based on search term
$sql = "SELECT * FROM course WHERE course_archive = 0 AND course_name LIKE ?";
$stmt = $conn->prepare($sql);
$search_term_wildcard = '%' . $search_term . '%';
$stmt->bind_param('s', $search_term_wildcard);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}

// Fetch sections
$sections = [];
if (!empty($courses)) {
    $course_codes = array_map(function($course) {
        return $course['course_code'];
    }, $courses);

    if (!empty($course_codes)) {
        $placeholders = implode(',', array_fill(0, count($course_codes), '?'));
        $sql_sections = "SELECT * FROM section WHERE course_code IN ($placeholders) AND section_archive = 0 GROUP BY section_number, course_code";
        $stmt_sections = $conn->prepare($sql_sections);
        $stmt_sections->bind_param(str_repeat('s', count($course_codes)), ...$course_codes);
        $stmt_sections->execute();
        $result_sections = $stmt_sections->get_result();

        if ($result_sections->num_rows > 0) {
            while ($row = $result_sections->fetch_assoc()) {
                $sections[$row['course_code']][] = $row;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="w3.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f1f1;
        }
        .top-menu {
            background-color: #3780a3;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            height: 7%;
            overflow: hidden;
        }
        .top-menu a {
            float: left;
            display: block;
            color: black;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .top-menu a:hover {
            background-color: #ddd;
            color: black;
        }
        .top-menu a.right {
            float: right;
        }
        .form-container {
            width: 90%;
            max-width: 1500px;
            padding: 25px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            margin: auto;
            margin-top: 50px;
        }
        .form-container input[type="text"], .form-container input[type="email"], .form-container input[type="password"], .form-container input[type="date"], .form-container select {
            width: calc(100% - 130px);
            padding: 8px;
            margin: 4px 0 16px 0;
            display: inline-block;
            border: none;
            background: #ebeff1;
        }
        .form-container input[type="text"]:focus, .form-container input[type="email"]:focus, .form-container input[type="password"]:focus, .form-container input[type="date"]:focus, .form-container select:focus {
            background-color: #ddd;
            outline: none;
        }
        .form-container button {
            background-color: #3780a3;
            color: white;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            margin-left: 10px;
            opacity: 0.9;
        }
        .form-container button:hover {
            opacity: 1;
        }
        .form-container label {
            margin-bottom: 4px;
            display: block;
            text-align: left;
        }
        .course-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .course-table th, .course-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .course-table th {
            background-color: #3780a3;
            color: white;
        }
        footer {
            background-color: #3780a3;
            color: black;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            position: auto;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

<!-- Top Menu -->
<div class="top-menu">
    <a href="homepage.php">Dashboard</a>
    <a href="profile.php">Profile</a>
    <a href="registration.php">Register</a>
    <a href="course.php">Courses</a>
    <a href="logout.php" class="right">Logout</a>
</div>

<!-- Main Content -->
<div class="form-container">
    <h1 class="w3-xxxlarge">Course Enrollment</h1>
    <p class="w3-large">Search and enroll in available courses.</p>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

    <form action="" method="get">
        <label for="search">Search Course</label>
        <div style="display: flex;">
            <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Enter course name">
            <button type="submit" class="w3-button w3-blue">Search</button>
        </div>
    </form>

    <?php if (!empty($courses)): ?>
    <div class="w3-container w3-margin-top">
        <h2 class="w3-large">Course List</h2>
        <table class="course-table">
            <tr>
                <th>Course Name</th>
                <th>Course Code</th>
                <th>Credit Hours</th>
                <th>Section</th>
                <th>Enroll</th>
            </tr>
            <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                <td><?php echo htmlspecialchars($course['course_credit_hour']); ?></td>
                <td>
                    <?php if (isset($sections[$course['course_code']])): ?>
                        <?php foreach ($sections[$course['course_code']] as $section): ?>
                            Section <?php echo htmlspecialchars($section['section_number']); ?><br>
                        <?php endforeach; ?>
                    <?php else: ?>
                        No sections available
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (isset($sections[$course['course_code']])): ?>
                        <?php foreach ($sections[$course['course_code']] as $section): ?>
                            <button onclick="document.getElementById('enrollModal<?php echo $section['section_number']; ?>').style.display='block'" class="w3-button w3-small w3-green w3-round w3-margin-top">Enroll</button><br>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <button class="w3-button w3-small w3-green w3-round w3-margin-top" disabled>Enroll</button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php else: ?>
    <p>No courses found</p>
    <?php endif; ?>

</div>

<!-- Enrollment Modals -->
<?php if (!empty($sections)): ?>
    <?php foreach ($sections as $course_code => $course_sections): ?>
        <?php foreach ($course_sections as $section): ?>
        <div id="enrollModal<?php echo $section['section_number']; ?>" class="w3-modal">
            <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
                <header class="w3-container w3-blue">
                    <span onclick="document.getElementById('enrollModal<?php echo $section['section_number']; ?>').style.display='none'" 
                    class="w3-button w3-display-topright w3-circle">&times;</span>
                    <h2>Enroll in <?php echo htmlspecialchars($course_code); ?> - Section <?php echo htmlspecialchars($section['section_number']); ?></h2>
                </header>
                <div class="w3-container">
                    <form action="" method="post">
                        <p>Course: <?php echo htmlspecialchars($course_code); ?></p>
                        <p>Section: <?php echo htmlspecialchars($section['section_number']); ?></p>
                        <p>Day: <?php echo htmlspecialchars($section['section_day']); ?></p>
                        <p>Start Time: <?php echo htmlspecialchars($section['section_start_time']); ?></p>
                        <p>End Time: <?php echo htmlspecialchars($section['section_end_time']); ?></p>
                        <p>Duration: <?php echo htmlspecialchars($section['section_duration']); ?></p>
                        <p>Quota: <?php echo htmlspecialchars($section['section_quota']); ?></p>
                        <p>Location: <?php echo htmlspecialchars($section['section_location']); ?></p>
                        <input type="hidden" name="course_code" value="<?php echo htmlspecialchars($course_code); ?>">
                        <input type="hidden" name="section_number" value="<?php echo htmlspecialchars($section['section_number']); ?>">
                        <input type="hidden" name="enroll" value="1">
                        <button type="submit" class="w3-button w3-green w3-margin-top">Enroll</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>

<!-- Footer -->
<footer>
    <p>Student Management System © 2024. All rights reserved.</p>
</footer>

<?php
function isRateLimited($student_matric_number, $max_attempts, $attempt_window, $conn) {
    $sql = "SELECT COUNT(*) AS attempt_count FROM enrollment_attempts WHERE student_matric_number = ? AND attempt_time > (NOW() - INTERVAL $attempt_window)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $student_matric_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['attempt_count'] >= $max_attempts;
}

function logEnrollmentAttempt($student_matric_number, $conn) {
    $sql = "INSERT INTO enrollment_attempts (student_matric_number, attempt_time) VALUES (?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $student_matric_number);
    $stmt->execute();
}
?>

</body>
</html>
