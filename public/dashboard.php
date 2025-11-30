<?php
require_once "../includes/auth.php";
require_login();

$role = $_SESSION['user']['role'];

switch ($role) {
    case 'admin':
        header('Location: /schoolms/admin/index.php');
        break;
    case 'teacher':
        header('Location: /schoolms/teacher/index.php');
        break;
    case 'student':
        header('Location: /schoolms/student/index.php');
        break;
    default:
        echo "Unknown role.";
}
exit;
