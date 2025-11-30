<?php
session_start();
session_destroy();
header('Location: /schoolms/public/login.php');
exit;
