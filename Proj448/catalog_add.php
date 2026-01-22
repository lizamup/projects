<?php
require_once 'error_handler.php';
session_start();
require_once 'dbconn.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    $stmt = $conn->prepare("INSERT INTO prj_t_catalog (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();

    header("Location: catalog_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Catalog</title></head>
<body>

<h2>Add Catalog</h2>

<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>
    <button type="submit">Save</button>
</form>

</body>
</html>
