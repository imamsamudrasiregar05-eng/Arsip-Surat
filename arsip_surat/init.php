<?php
// init.php - safe session start and common helpers


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// helper: redirect to login if not logged
function ensure_login() {
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
}
?>