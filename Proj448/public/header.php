<?php
require_once "dbconn.php";

// Load saved color settings
$settings = [
    'h1_color'   => '#000000',
    'h2_color'   => '#000000',
    'h3_color'   => '#000000',
    'p_color'    => '#333333',
    'header_bg'  => '#0d6efd',
    'body_bg'    => '#ffffff',
    'footer_bg'  => '#222222'
];

$res = $conn->query("SELECT * FROM prj_t_settings WHERE id = 1");
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    foreach ($settings as $k => $v) {
        if (!empty($row[$k])) {
            $settings[$k] = $row[$k];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant Store</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: <?= $settings['body_bg']; ?>;
        }
        header, .navbar {
            background-color: <?= $settings['header_bg']; ?> !important;
        }
        footer {
            background-color: <?= $settings['footer_bg']; ?>;
            color: white;
            padding: 15px;
            text-align: center;
        }
        h1 { color: <?= $settings['h1_color']; ?>; }
        h2 { color: <?= $settings['h2_color']; ?>; }
        h3 { color: <?= $settings['h3_color']; ?>; }
        p  { color: <?= $settings['p_color']; ?>; }

        .product-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
    </style>
</head>
<body>
