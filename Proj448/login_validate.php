<?php
// admin/login_validate.php
require_once 'error_handler.php';
session_start();
require_once 'dbconn.php';

try {

    if (!isset($_POST['name'], $_POST['password'])) {
        $_SESSION['error_msg'] = "Invalid input";
        header("Location: login.php");
        exit();
    }

    $name = $_POST['name'];
    $password = $_POST['password'];

    // Prepare secure statement
    $stmt = $conn->prepare("SELECT ID, name FROM prj_t_user 
                            WHERE name = ? AND password = SHA2(?, 256)");
    $stmt->bind_param("ss", $name, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Successful login
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['ID'];
        $_SESSION['user_name'] = $row['name'];

        header("Location: home.php");
        exit();
    } else {
        // Failed login
        $_SESSION['error_msg'] = "Invalid username or password";
        header("Location: login.php");
        exit();
    }

} catch (Exception $e) {
    $_SESSION['error_msg'] = "An error occurred during login";
    header("Location: login.php");
    exit();
}
