<?php
require_once "dbconn.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$messages = $conn->query("SELECT * FROM prj_t_contact ORDER BY submitted_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">

    <div class="card shadow-lg border-0">
        <div class="card-body">

            <h2 class="text-primary mb-3">📨 Contact Messages</h2>

            <a href="home.php" class="btn btn-secondary btn-sm mb-3">⬅ Back to Admin</a>

            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th width="70">Delete</th>
                    </tr>
                </thead>

                <tbody>
                <?php if ($messages->num_rows > 0): ?>
                    <?php while ($m = $messages->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($m['name']) ?></td>
                            <td><?= htmlspecialchars($m['email']) ?></td>
                            <td><?= nl2br(htmlspecialchars($m['message'])) ?></td>
                            <td><?= $m['submitted_at'] ?></td>
                            <td>
                                <a href="contact_delete.php?id=<?= $m['ID'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Delete this message?')">X</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No messages found.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>

        </div>
    </div>
</div>
</body>
</html>
