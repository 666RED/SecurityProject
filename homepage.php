<?php
session_start();

if (!isset($_SESSION['student_matric_number'])) {
    header('Location: index.php');
    exit();
}

// Check if session is expired
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $_SESSION['expire_time']) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();
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
            position: fixed;
            top: 0;
            z-index: 1;
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
        .news-container {
            width: 90%;
            max-width: 600px;
            padding: 25px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            margin: auto;
            margin-top: 100px; /* Adjust margin to account for fixed top menu */
        }
        .news-container ul {
            list-style-type: none;
            padding: 0;
        }
        .news-container ul li {
            background: #fff;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        .news-container ul li span {
            display: block;
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
<div class="news-container">
    <h1 class="w3-xxxlarge">Welcome to the Student Management System</h1>
    <p class="w3-large">Stay updated with the latest news and announcements.</p>

    <!-- News Section -->
    <div class="w3-panel w3-border w3-light-grey">
        <h2 class="w3-large w3-border-bottom">News</h2>
        <ul class="w3-ul">
            <li><strong>23/05/2024</strong> The semester starts on 1st September. Make sure to register your courses by 25th August.</li>
            <li><strong>17/05/2024</strong> New library hours: Mon-Fri, 8 AM to 8 PM.</li>
            <li><strong>15/05/2024</strong> Student orientation will be held online this year due to ongoing health concerns.</li>
            <li><strong>28/04/2024</strong> Graduation ceremony is scheduled for 20th November. Details to follow.</li>
            <li><strong>15/04/2024</strong> New cafeteria menu items available from next week.</li>
            <li><strong>09/04/2024</strong> Campus Wi-Fi has been upgraded for better connectivity.</li>
            <li><strong>20/03/2024</strong> Mid-term exams will take place from 15th to 20th October.</li>
            <li><strong>19/03/2024</strong> Submit your research papers by 30th September for the annual student conference.</li>
            <li><strong>11/03/2024</strong> Join us for the virtual job fair on 10th October.</li>
            <li><strong>04/03/2024</strong> Participate in the inter-college sports meet starting from 5th December.</li>
        </ul>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>Student Management System © 2024. All rights reserved.</p>
</footer>

</body>
</html>
