<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: login.php');
    exit;
}

$inactive_time = 7200;
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > $inactive_time)) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$_SESSION['login_time'] = time();
?>