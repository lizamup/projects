<?php
require_once 'error_handler.php';
session_start();
require_once 'dbconn.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM prj_t_catalog WHERE ID=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: catalog_list.php");
exit();
