<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_login() {
    if (empty($_SESSION['user'])) {
        header('Location: /schoolms/public/login.php');
        exit;
    }
}

function require_role($role) {
    require_login();
    if ($_SESSION['user']['role'] !== $role) {
        http_response_code(403);
        echo "Access denied.";
        exit;
    }
}
