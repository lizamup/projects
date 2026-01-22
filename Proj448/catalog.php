<?php
require_once 'error_handler.php';
session_start();
require_once 'dbconn.php'; // mysqli

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// CREATE
if (isset($_POST['action']) && $_POST['action'] == "add") {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO prj_t_catalog (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->close();
    header("Location: catalog.php");
    exit();
}

// UPDATE
if (isset($_POST['action']) && $_POST['action'] == "edit") {
    $id   = $_POST['id'];
    $name = $_POST['name'];
    $stmt = $conn->prepare("UPDATE prj_t_catalog SET name=? WHERE ID=?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: catalog.php");
    exit();
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM prj_t_catalog WHERE ID=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: catalog.php");
    exit();
}

// FETCH ALL
$result = $conn->query("SELECT * FROM prj_t_catalog ORDER BY ID DESC");
$catalogs = [];
while ($row = $result->fetch_assoc()) {
    $catalogs[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Catalog CRUD</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">

    <a href="home.php" class="btn btn-secondary mb-3">⬅ Back to Home</a>

    <div class="card shadow border-0">
        <div class="card-body">

            <h2 class="text-primary mb-4">Catalog Management</h2>

            <!-- ADD CATEGORY -->
            <h4>Add New Category</h4>
            <form method="POST" class="row g-3 mb-4">
                <input type="hidden" name="action" value="add">

                <div class="col-md-6">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-success">Add Category</button>
                </div>
            </form>

            <hr>

            <!-- CATEGORY TABLE -->
            <h4>Categories</h4>
            <table class="table table-bordered table-hover bg-white shadow-sm">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th style="width: 300px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($catalogs as $row): ?>
                    <tr>
                        <td><?= $row['ID'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>

                            <!-- UPDATE FORM INLINE -->
                            <form method="POST" class="d-flex gap-2 align-items-center">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?= $row['ID'] ?>">

                                <input type="text" name="name"
                                       class="form-control"
                                       value="<?= htmlspecialchars($row['name']) ?>"
                                       required>

                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            </form>

                            <a href="catalog.php?delete=<?= $row['ID'] ?>"
                               onclick="return confirm('Delete this item?');"
                               class="btn btn-danger btn-sm mt-1">
                               Delete
                            </a>

                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>

</div>

</body>
</html>
