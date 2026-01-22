<?php
require_once "dbconn.php";
session_start();

// Protect admin page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);

// Delete message from DB
$conn->query("DELETE FROM prj_t_contact WHERE ID = $id");

// Redirect back to inbox
header("Location: contact.php");
exit();
