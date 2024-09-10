<?php
include_once './utils.php';
require_once './logger.php';
require './config.php';
require './csrf.php';

$logger = Log::getInstance();
$user_id = $_SESSION['user_id'];


if (!isset($_SESSION['user_id'])) {
    redirect_with_message("index", "You are not logged in");
    exit;
}

// CSRF token check
if(!isset($_POST['csrf']) || !is_string($_POST['csrf'])){
    $logger->warning('Logout called without a CSRF token');
    redirect_to_page("index");
}

if(!verify_and_regenerate_csrf_token($_POST['csrf'])){
    $logger->warning("CSRF tokens do not match", ['csrf' => $_POST['csrf']]);
    redirect_to_page("index");
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
$logger->info("User logged out", ['user_id' => $user_id]);
redirect_with_message("index", "You have been logged out");