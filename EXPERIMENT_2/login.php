<?php
session_start();
include 'config.php';  // Include DB connection

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate Fields
    if (empty($email) || empty($password)) {
        $message = "All fields are required!";
    } else {
        // Check user in DB
        $stmt = $conn->prepare("SELECT user_id, name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $name, $email_db, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // Login Success
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $name;
                header("Location: catalogue.php");
                exit();
            } else {
                $message = "Incorrect Password!";
            }
        } else {
            $message = "No account found with this Email!";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bookstore Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .background-image {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('assets/login.jpg') no-repeat center center;
      background-size: cover;
      z-index: -1;
    }
    .form-container {
      background: rgba(0, 0, 0, 0.6);
      border-radius: 15px;
      max-width: 450px;
      width: 800px;
      height: 500px;
      color: #cec9c2;
      position: relative;
      padding: 2.5rem;
      padding-left: 60px;
      z-index: 1;
      overflow: hidden;
    }
    .form-container::after {
      content: "";
      position: absolute;
      width: 100%;
      height: 100%;
      border: 2px dashed #e0ce24;
      inset: 20px;
      border-radius: 25px;
      pointer-events: none;
      z-index: 3;
    }
    .form-wrapper {
      height: 100vh;
      display: flex;
      align-items: center;
      padding-left: 12%;
    }
    h2 {
      font-weight: 700;
      margin-bottom: 1.5rem;
    }
    @media (max-width: 768px) {
      .form-wrapper {
        justify-content: center;
        padding-left: 100px;
      }
      .form-container {
        max-width: 100%;
        width: 100%;
      }
    }
    .back-fab {
      position: fixed;
      top: 20px;
      left: 20px;
      width: 50px;
      height: 50px;
      background-color: #ffc107;
      color: #140303;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      transition: all 0.3s ease;
      z-index: 1000;
    }
    .back-fab:hover {
      background-color: #e0a800;
      transform: scale(1.1);
    }
    .back-fab i {
      font-size: 1.5rem;
    }
  </style>
</head>
<body>

  <!-- Background Image -->
  <div class="background-image"></div>

  <!-- Form Section -->
  <div class="container-fluid">
    <a href="javascript:history.back()" class="back-fab">
      <i class="bi bi-arrow-left"></i>
    </a>
    <div class="row">
      <div class="col-12 form-wrapper">
        <div class="form-container">
          <h2 class="text-center mt-3"> <i class="bi bi-book-half text-light me-2"></i> BookNext</h2>
          <h5 class="text-center text-warning mt-0 pt-0">Start Your Journey with Books!!!</h5>
          
          <?php if (!empty($message)): ?>
              <div class="alert alert-danger"><?php echo $message; ?></div>
          <?php endif; ?>

          <form method="POST">
            <div class="my-3">
              <label for="email" class="form-label">Email</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" name="email" id="email" placeholder="Enter your email" required />
              </div>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required />
              </div>
            </div>
            <div class="d-grid mt-5">
              <button type="submit" class="btn btn-warning">Let Me In >></button>
            </div>
            <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register here</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
