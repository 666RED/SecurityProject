<?php 
  include "db.php";

  $staff_id = mysqli_real_escape_string($conn, $_POST['id']);
    $staff_password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password
    $hashed_password = password_hash($staff_password, PASSWORD_DEFAULT);

    // Create SQL query to insert data into staff table
    $sql = "INSERT INTO staff (staff_id, staff_password) VALUES ('$staff_id', '$hashed_password')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "Staff record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
?>