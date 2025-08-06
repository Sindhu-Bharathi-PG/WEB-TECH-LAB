<?php
include 'config.php';  // Include DB connection

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "All fields are required!";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // Check if Email Exists
        $checkEmail = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();

        if ($checkEmail->num_rows > 0) {
            $message = "Email already registered!";
        } else {
            // Hash Password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert User
            $insertUser = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $insertUser->bind_param("sss", $name, $email, $hashedPassword);

            if ($insertUser->execute()) {
                $message = "Registration Successful! You can now <a href='login.php'>Login</a>.";
            } else {
                $message = "Error in Registration!";
            }

            $insertUser->close();
        }

        $checkEmail->close();
    }
}
?>
<!-- (HTML Part remains same as before) -->
<!DOCTYPE html>
<html>

<head>
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('assets/register.jpg');
            /* Make sure file name is correct */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
        }

        .overlay {
            height: 100vh;
            display: flex;
            justify-content: flex-end;
            /* Align to right */
            align-items: center;
            padding-right: 10%;
            /* Adjust space from right edge */
        }

        .form-container {
            background: rgba(0, 0, 0, 0.6);
            border-radius: 15px;
            max-width: 450px;
            width: 800px;
            height: 600px;
            color: #cec9c2;
            position: relative;
            padding: 2.5rem;
            padding-left: 60px;
            z-index: 1;
            overflow: hidden;
        }

        .form-container::before,
        .form-container::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 25px;
            pointer-events: none;
            box-sizing: border-box;
        }



        .form-container::after {
            border: 2px dashed #e0ce24;
            inset: 20px;
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

        .logo {
            display: block;
            margin: 0 auto 1.5rem auto;
            height: 60px;
            width: 60px;
        }

        .back-fab {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background-color: #ffc107;
            color: #140303;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
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
    <div class="overlay container-fluid">
        <a href="javascript:history.back()" class="back-fab">
            <i class="bi bi-arrow-right"></i>
        </a>
        <div class="form-container">
            <h2 class="text-center mt-3"> <i class="bi bi-book-half text-light me-2 "></i> BookNext</h2>
            <h5 class="text-center text-warning mt-0 pt-0">Start Your Journey with Books!!!</h5> <?php if (isset($message)): ?>
                <!--                 <div class="alert alert-info"><?php echo $message; ?></div>
 --> <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
                </div>
                <button type="submit" class="btn btn-warning w-100 mt-4">Member Yourself !!</button>
            </form>
            <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>

</html>