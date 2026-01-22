<?php
require_once 'error_handler.php';
session_start();
require_once 'dbconn.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

// Get all catalog items
$result = $conn->query("SELECT * FROM prj_t_catalog ORDER BY ID DESC");
?>

<!DOCTYPE html>
<html>
<head><title>Catalog List</title></head>
<body>

<h2>Catalog List</h2>
<a href="catalog_add.php">+ Add Catalog</a> | <a href="home.php">Home</a><br><br>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Actions</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['ID']; ?></td>
    <td><?= htmlspecialchars($row['name']); ?></td>
    <td>
        <a href="catalog_edit.php?id=<?= $row['ID']; ?>">Edit</a> | 
        <a href="catalog_delete.php?id=<?= $row['ID']; ?>" onclick="return confirm('Delete this item?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
