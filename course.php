<?php
require 'database.php';

session_start();

if (!isset($_SESSION['student_matric_number'])) {
    header('Location: index.php');
    exit();
}

$student_matric_number = $_SESSION['student_matric_number']; // Assuming the student matric number is stored in session

// Fetch enrolled courses
$sql = "SELECT ss.course_code, c.course_name, c.course_credit_hour, ss.course_mark, ss.course_grade, ss.section_number, ss.lecturer_id, ss.enrollment_date, ss.expired
        FROM student_section ss 
        JOIN course c ON ss.course_code = c.course_code 
        WHERE ss.student_matric_number = '$student_matric_number'";
$result = $conn->query($sql);

$courses = [];
$total_credits = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
        $total_credits += $row['course_credit_hour'];
    }
}

// Generate report
if (isset($_POST['generate_report'])) {
    $report = "Course Report for Student Matric Number: $student_matric_number\n\n";
    $report .= "Course Code\tCourse Name\tCredit Hours\tMarks\tGrade\tSection Number\tLecturer ID\tEnrollment Date\tExpired\n";
    foreach ($courses as $course) {
        $report .= "{$course['course_code']}\t{$course['course_name']}\t{$course['course_credit_hour']}\t{$course['course_mark']}\t{$course['course_grade']}\t{$course['section_number']}\t{$course['lecturer_id']}\t{$course['enrollment_date']}\t{$course['expired']}\n";
    }
    $report .= "\nTotal Credits: $total_credits\n";
    
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="course_report.txt"');
    echo $report;
    exit();
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
        .form-container button {
            background-color: #3780a3;
            color: white;
            padding: 12px 15px;
            border: none;
            cursor: pointer;
            width: 100%;
            opacity: 0.9;
            margin-top: 10px;
        }
        .form-container button:hover {
            opacity: 1;
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
    <h1 class="w3-xxxlarge">My Courses</h1>
    <p class="w3-large">View your enrolled courses and their details.</p>

    <?php if (!empty($courses)): ?>
    <div class="w3-container w3-margin-top">
        <h2 class="w3-large">Course List</h2>
        <table class="course-table">
            <tr>
                <th>Course Name</th>
                <th>Course Code</th>
                <th>Credit Hours</th>
                <th>Marks</th>
                <th>Grade</th>
                <th>Section Number</th>
                <th>Lecturer ID</th>
                <th>Enrollment Date</th>
                <th>Expired</th>
            </tr>
            <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo $course['course_name']; ?></td>
                <td><?php echo $course['course_code']; ?></td>
                <td><?php echo $course['course_credit_hour']; ?></td>
                <td><?php echo $course['course_mark']; ?></td>
                <td><?php echo $course['course_grade']; ?></td>
                <td><?php echo $course['section_number']; ?></td>
                <td><?php echo $course['lecturer_id']; ?></td>
                <td><?php echo $course['enrollment_date']; ?></td>
                <td><?php echo $course['expired']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <h3>Total Credits: <?php echo $total_credits; ?></h3>
    </div>

    <form action="" method="post" class="w3-container w3-margin-top">
        <button type="submit" name="generate_report" class="w3-button w3-blue">Generate Report</button>
    </form>
    <?php else: ?>
    <p>No courses enrolled</p>
    <?php endif; ?>

</div>

<!-- Footer -->
<footer>
    <p>Student Management System © 2024. All rights reserved.</p>
</footer>

</body>
</html>
