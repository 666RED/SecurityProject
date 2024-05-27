<?php 
  session_start();

  if(isset($_SESSION['errorMessage'])) {
    $errorMessage = $_SESSION['errorMessage'];
    unset($_SESSION['errorMessage']);
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
  body,
  html {
    height: 100%;
    margin: 0;
  }

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
  <?php
    if(!empty($errorMessage)) {
      echo 
        '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
    }
  ?>
  <div class="d-flex justify-content-center align-items-center h-100">
    <div>
      <h3 class="text-center">Welcome back!</h3>
      <p class="text-center">Login to your account :)</p>
      <form style="min-width: 400px" action="./authentication/verifyLogin.php" method="POST">
        <!-- USER ID -->
        <label for="id-input">User ID</label>
        <input type="text" class="form-control" id="id-input" name="user-id" placeholder="Enter user ID" required>
        <!-- PASSWORD & ICONS -->
        <label for="password-input" class="mt-3">Password</label>
        <div class="position-relative">
          <i class="fa-solid fa-eye icon" id="open-eye" onclick="handleViewPassword(1)"></i>
          <i class="fa-solid fa-eye-slash icon d-none" id="close-eye" onclick="handleViewPassword(0)"></i>
          <input type="password" class="form-control mt-2" id="password-input" placeholder="Enter password"
            name="password" required>
        </div>
        <!-- LOGIN BUTTON -->
        <div class="text-center">
          <button class="btn btn-primary w-50  mt-5" name="login">LOGIN</button>
        </div>
      </form>
    </div>
  </div>

  <script>
  const handleViewPassword = (value) => {
    if (value === 1) {
      document.getElementById("open-eye").classList.add("d-none")
      document.getElementById("close-eye").classList.remove("d-none")
      document.getElementById("close-eye").classList.add("d-block")
      document.getElementById("password-input").type = "text"
    } else {
      document.getElementById("open-eye").classList.remove("d-none")
      document.getElementById("open-eye").classList.add("d-block")
      document.getElementById("close-eye").classList.add("d-none")
      document.getElementById("password-input").type = "password"
    }
  }
  </script>
</body>

</html>