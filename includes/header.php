<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lord Buddha School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/schoolms/public/assets/css/style.css">
</head>
<body>
<header class="topbar">
    <div class="topbar-inner">
        <a href="/schoolms/public/index.php" class="brand">
            <div class="brand-mark">LB</div>
            <div class="brand-text">
                <span class="brand-name">Lord Buddha School</span>
                <!-- <span class="brand-tagline">Where Wisdom &amp; Compassion Meet</span> -->
            </div>
        </a>
        <nav class="main-nav">
            <a href="/schoolms/public/index.php#about">About</a>
            <a href="/schoolms/public/index.php#academics">Academics</a>
            <a href="/schoolms/public/index.php#admissions">Admissions</a>
            <a href="/schoolms/public/index.php#life">Campus Life</a>
            <a href="/schoolms/public/index.php#notices">Notices</a>
            <?php if (!empty($_SESSION['user'])): ?>
                <a href="/schoolms/public/dashboard.php" class="nav-cta">Portal</a>
            <?php else: ?>
                <a href="/schoolms/public/login.php" class="nav-cta">Portal Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="page-content">
