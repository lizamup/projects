<?php
// admin/login.php
require_once 'error_handler.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f0f2f5;
        }
        .login-card {
            max-width: 420px;
            margin: 70px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
        }
        .login-title {
            text-align: center;
            margin-bottom: 25px;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-card">

        <h2 class="login-title">Admin Login</h2>

        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error_msg']; ?>
            </div>
            <?php unset($_SESSION['error_msg']); ?>
        <?php endif; ?>

        <form action="login_validate.php" method="POST">

            <!-- USERNAME -->
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!-- PASSWORD -->
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <!-- SUBMIT -->
            <button type="submit" class="btn btn-primary w-100">Login</button>

        </form>

    </div>
</div>

</body>
</html>
