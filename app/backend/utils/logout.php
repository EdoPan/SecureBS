<?php
include_once './utils.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    redirect_with_message("index", "You are not logged in");
    exit;
}

// Unset all of the session variables.
$_SESSION = [];

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
redirect_with_message("index", "You have been logged out");