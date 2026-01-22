<?php
require_once 'error_handler.php';
session_start();
require_once 'dbconn.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT name FROM prj_t_catalog WHERE ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST['name'];

    $u = $conn->prepare("UPDATE prj_t_catalog SET name=? WHERE ID=?");
    $u->bind_param("si", $newName, $id);
    $u->execute();

    header("Location: catalog_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Catalog</title></head>
<body>

<h2>Edit Catalog</h2>

<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($name); ?>" required><br><br>
    <button type="submit">Update</button>
</form>

</body>
</html>
