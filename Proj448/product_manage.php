<?php
require_once "dbconn.php";
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ---- DELETE PRODUCT ----
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM prj_t_product WHERE ID = $id");
    header("Location: product_manage.php");
    exit();
}

// ---- EDIT MODE ----
$editing = false;
$product = [
    'name' => '',
    'price' => '',
    'description' => '',
    'image' => '',
    'cat_id' => ''
];

if (isset($_GET['edit'])) {
    $editing = true;
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM prj_t_product WHERE ID = $id");
    $product = $res->fetch_assoc();
}

// ---- SAVE FORM ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = $_POST['id'] ?? '';
    $name      = $conn->real_escape_string($_POST['name']);
    $price     = floatval($_POST['price']);
    $desc      = $conn->real_escape_string($_POST['description']);
    $img       = $conn->real_escape_string($_POST['image']); // existing filename
    $cat       = intval($_POST['cat_id']);

    // ---------- HANDLE FILE UPLOAD ----------
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {

        $tmpName  = $_FILES['image_file']['tmp_name'];
        $origName = basename($_FILES['image_file']['name']);
        $ext      = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
        $allowed  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($ext, $allowed)) {

            // Generate unique filename
            $newName = 'prod_' . uniqid() . '.' . $ext;

            // IMPORTANT: Save to ROOT images folder, not admin/images
            $targetPath = dirname(__DIR__) . "/images/" . $newName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $img = $newName;  // store new filename in DB
            }
        }
    }
    // ----------------------------------------

    if ($id == '') {
        // INSERT
        $conn->query("INSERT INTO prj_t_product (name, price, description, image, cat_id)
                      VALUES ('$name', $price, '$desc', '$img', $cat)");
    } else {
        // UPDATE
        $conn->query("UPDATE prj_t_product
                      SET name='$name',
                          price=$price,
                          description='$desc',
                          image='$img',
                          cat_id=$cat
                      WHERE ID=$id");
    }

    header("Location: product_manage.php");
    exit();
}

// Load categories
$cats = $conn->query("SELECT * FROM prj_t_catalog ORDER BY name ASC");

// Load products
$list = $conn->query("SELECT * FROM prj_t_product ORDER BY ID DESC");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>

   <?php
require_once "dbconn.php";
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ---- DELETE PRODUCT ----
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM prj_t_product WHERE ID = $id");
    header("Location: product_manage.php");
    exit();
}

// ---- EDIT MODE ----
$editing = false;
$product = [
    'name' => '',
    'price' => '',
    'description' => '',
    'image' => '',
    'cat_id' => ''
];

if (isset($_GET['edit'])) {
    $editing = true;
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM prj_t_product WHERE ID = $id");
    $product = $res->fetch_assoc();
}

// ---- SAVE FORM ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = $_POST['id'] ?? '';
    $name      = $conn->real_escape_string($_POST['name']);
    $price     = floatval($_POST['price']);
    $desc      = $conn->real_escape_string($_POST['description']);
    $img       = $conn->real_escape_string($_POST['image']); // existing filename or manual entry
    $cat       = intval($_POST['cat_id']);

    // ---------- HANDLE FILE UPLOAD ----------
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {

        $tmpName  = $_FILES['image_file']['tmp_name'];
        $origName = basename($_FILES['image_file']['name']);
        $ext      = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
        $allowed  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($ext, $allowed)) {
            // unique filename
            $newName = 'prod_' . uniqid() . '.' . $ext;

            // ✅ Save into /images inside THIS project folder
            $targetPath = __DIR__ . "/images/" . $newName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $img = $newName;  // store just the filename in DB
            }
        }
    }
    // ----------------------------------------

    if ($id == '') {
        // INSERT
        $conn->query("INSERT INTO prj_t_product (name, price, description, image, cat_id)
                      VALUES ('$name', $price, '$desc', '$img', $cat)");
    } else {
        // UPDATE
        $conn->query("UPDATE prj_t_product
                      SET name='$name',
                          price=$price,
                          description='$desc',
                          image='$img',
                          cat_id=$cat
                      WHERE ID=$id");
    }

    header("Location: product_manage.php");
    exit();
}

// Load categories
$cats = $conn->query("SELECT * FROM prj_t_catalog ORDER BY name ASC");

// Load products
$list = $conn->query("SELECT * FROM prj_t_product ORDER BY ID DESC");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <!-- HEADER -->
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body">
            <h2 class="text-primary mb-3">🛒 Manage Products</h2>
            <a href="home.php" class="btn btn-secondary btn-sm">⬅ Back to Dashboard</a>
        </div>
    </div>

    <div class="row">

        <!-- PRODUCT LIST -->
        <div class="col-md-7">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-body">
                    <h4 class="text-primary mb-3">Product List</h4>

                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th width="140">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($p = $list->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['name']); ?></td>
                                <td>$<?= number_format($p['price'], 2); ?></td>
                                <td>
                                    <a href="?edit=<?= $p['ID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="?delete=<?= $p['ID']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Delete this product?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <!-- ADD / EDIT FORM -->
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-body">

                    <h4 class="text-primary mb-3">
                        <?= $editing ? "✏️ Edit Product" : "➕ Add Product" ?>
                    </h4>

                    <form method="post" enctype="multipart/form-data">

                        <input type="hidden" name="id" value="<?= $editing ? $product['ID'] : '' ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Product Name</label>
                            <input type="text" class="form-control"
                                   name="name" value="<?= htmlspecialchars($product['name']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Price</label>
                            <input type="text" class="form-control"
                                   name="price" value="<?= htmlspecialchars($product['price']); ?>" required>
                        </div>

                        <!-- MANUAL FILENAME (optional) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Image Filename (optional)</label>
                            <input type="text" class="form-control"
                                   name="image" value="<?= htmlspecialchars($product['image']); ?>">
                            <small class="text-muted">You can type a filename OR upload below.</small>
                        </div>

                        <!-- FILE UPLOAD -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Image (optional)</label>
                            <input type="file" class="form-control" name="image_file" accept="image/*">
                        </div>

                        <!-- CURRENT IMAGE PREVIEW -->
                        <?php if (!empty($product['image'])): ?>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Current Image</label><br>
                                <img src="images/<?= htmlspecialchars($product['image']); ?>"
                                     style="max-width: 100%; max-height: 180px; border-radius: 4px;">
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <select class="form-select" name="cat_id">
                                <?php while ($c = $cats->fetch_assoc()): ?>
                                    <option value="<?= $c['ID']; ?>"
                                        <?= $c['ID'] == $product['cat_id'] ? "selected" : "" ?>>
                                        <?= htmlspecialchars($c['name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea class="form-control" name="description" rows="3"><?= htmlspecialchars($product['description']); ?></textarea>
                        </div>

                        <button class="btn btn-primary w-100">
                            <?= $editing ? "Update Product" : "Add Product" ?>
                        </button>

                    </form>

                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>
