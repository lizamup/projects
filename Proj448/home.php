<?php
// admin/home.php
require_once 'error_handler.php';
session_start();

// Redirect if user is NOT logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Home</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow-lg border-0">
        <div class="card-body">

            <h2 class="mb-4 text-center text-primary">
                Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?>!
            </h2>

            <p class="text-center mb-4">
                You have successfully logged in to the Admin Dashboard.
            </p>

            <nav>
                <ul class="list-group">

                    <!-- MANAGE CATALOG -->
                    <li class="list-group-item">
                        <a href="catalog.php" class="text-decoration-none fw-bold">
                            📁 Manage Catalog
                        </a>
                    </li>

                    <!-- MANAGE PRODUCTS (FIXED LINK) -->
                    <li class="list-group-item">
                        <a href="product_manage.php" class="text-decoration-none fw-bold">
                            🛒 Manage Products
                        </a>
                    </li>

                    <!-- SITE COLOR SETTINGS -->
                    <li class="list-group-item">
                        <a href="admin_colors.php" class="text-decoration-none fw-bold">
                            🎨 Site Color Settings
                        </a>
                    </li>

                    <!-- VIEW CONTACT MESSAGES -->
                    <li class="list-group-item">
                        <a href="contact.php" class="text-decoration-none fw-bold">
                            📨 View Contact Messages
                        </a>
                    </li>

                    <!-- LOGOUT -->
                    <li class="list-group-item">
                        <a href="logout.php" class="text-danger fw-bold text-decoration-none">
                            🚪 Logout
                        </a>
                    </li>

                </ul>
            </nav>

        </div>
    </div>

</div>

</body>
</html>


