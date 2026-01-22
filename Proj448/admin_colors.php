<?php
// admin_colors.php
require_once "dbconn.php";
session_start();

// PROTECT ADMIN PAGE
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Create settings table if it doesn't exist yet
$conn->query("
    CREATE TABLE IF NOT EXISTS prj_t_settings (
        id INT PRIMARY KEY,
        h1_color   VARCHAR(7),
        h2_color   VARCHAR(7),
        h3_color   VARCHAR(7),
        p_color    VARCHAR(7),
        header_bg  VARCHAR(7),
        body_bg    VARCHAR(7),
        footer_bg  VARCHAR(7)
    )
");

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Simple sanitizing – fine for class project
    $h1   = $conn->real_escape_string($_POST['h1']   ?? '#000000');
    $h2   = $conn->real_escape_string($_POST['h2']   ?? '#000000');
    $h3   = $conn->real_escape_string($_POST['h3']   ?? '#000000');
    $p    = $conn->real_escape_string($_POST['p']    ?? '#333333');
    $head = $conn->real_escape_string($_POST['head'] ?? '#0d6efd');
    $body = $conn->real_escape_string($_POST['body'] ?? '#ffffff');
    $foot = $conn->real_escape_string($_POST['foot'] ?? '#222222');

    // REPLACE = insert or update row with id = 1
    $sql = "
        REPLACE INTO prj_t_settings
            (id, h1_color, h2_color, h3_color, p_color, header_bg, body_bg, footer_bg)
        VALUES
            (1, '$h1', '$h2', '$h3', '$p', '$head', '$body', '$foot')
    ";

    $conn->query($sql);
}

// Load current settings (if any)
$set = [];
$result = $conn->query("SELECT * FROM prj_t_settings WHERE id = 1");
if ($result && $result->num_rows > 0) {
    $set = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin – Site Color Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">

    <h1 class="mb-4">Site Color Settings</h1>

    <div class="mb-3">
        <a href="home.php" class="btn btn-secondary">← Back to Admin Home</a>
    </div>

    <form method="post" class="card p-4 shadow-sm">

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">H1 Color</label>
                <input type="color" name="h1"
                       class="form-control form-control-color"
                       value="<?= $set['h1_color'] ?? '#000000' ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">H2 Color</label>
                <input type="color" name="h2"
                       class="form-control form-control-color"
                       value="<?= $set['h2_color'] ?? '#000000' ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">H3 Color</label>
                <input type="color" name="h3"
                       class="form-control form-control-color"
                       value="<?= $set['h3_color'] ?? '#000000' ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Paragraph Color (P)</label>
                <input type="color" name="p"
                       class="form-control form-control-color"
                       value="<?= $set['p_color'] ?? '#333333' ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Header Background</label>
                <input type="color" name="head"
                       class="form-control form-control-color"
                       value="<?= $set['header_bg'] ?? '#0d6efd' ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Body Background</label>
                <input type="color" name="body"
                       class="form-control form-control-color"
                       value="<?= $set['body_bg'] ?? '#ffffff' ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Footer Background</label>
                <input type="color" name="foot"
                       class="form-control form-control-color"
                       value="<?= $set['footer_bg'] ?? '#222222' ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Save Colors</button>

    </form>

</div>

</body>
</html>

