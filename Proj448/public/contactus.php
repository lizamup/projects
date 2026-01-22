<?php
// public/contactus.php
require_once "dbconn.php";
include "header.php";
include "nav.php";

// --- make sure contact table exists (safe if it already exists) ---
$conn->query("
    CREATE TABLE IF NOT EXISTS prj_t_contact (
        ID INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

$success = "";
$error   = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // basic sanitizing
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $msg   = trim($_POST['message'] ?? '');

    if ($name === "" || $email === "" || $msg === "") {
        $error = "All fields are required.";
    } else {
        // prepared statement for safety
        $stmt = $conn->prepare("
            INSERT INTO prj_t_contact (name, email, message)
            VALUES (?, ?, ?)
        ");

        if ($stmt) {
            $stmt->bind_param("sss", $name, $email, $msg);
            if ($stmt->execute()) {
                $success = "Your message has been sent!";
            } else {
                $error = "Error saving message.";
                // for debugging only, you could temporarily echo this:
                // $error = "Error saving message: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Error preparing statement.";
            // for debugging only:
            // $error = "Error preparing statement: " . $conn->error;
        }
    }
}
?>

<div class="container my-5">

    <h2 class="mb-4">Contact Us</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="card p-4 shadow-sm border-0">

        <div class="mb-3">
            <label class="form-label fw-bold">Your Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Your Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Message</label>
            <textarea name="message" class="form-control" rows="4" required></textarea>
        </div>

        <button class="btn btn-primary">Send Message</button>

    </form>
</div>

<?php include "footer.php"; ?>


