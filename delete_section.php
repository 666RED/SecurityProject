<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['matric_number']) && isset($_POST['course_code']) && isset($_POST['section_number'])) {
    $student_matric_number = $_POST['matric_number'];
    $course_code = $_POST['course_code'];
    $section_number = $_POST['section_number'];

    $sql = "DELETE FROM student_section WHERE student_matric_number = ? AND course_code = ? AND section_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $student_matric_number, $course_code, $section_number);

    if ($stmt->execute()) {
        http_response_code(200); // OK status code
        echo json_encode(['message' => 'Record deleted successfully.']);
    } else {
        http_response_code(500); // Internal Server Error status code
        echo json_encode(['error' => 'Error deleting record from database.']);
    }
} else {
    http_response_code(400); // Bad Request status code
    echo json_encode(['error' => 'Invalid request.']);
}

$stmt->close();
$conn->close();
?>