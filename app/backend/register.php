<?php
require_once './utils/db_manager.php';
require_once './utils/logger.php';
include_once 'utils/utils.php';
require_once './utils/config.php';
require_once './utils/csrf.php';

$logger = Log::getInstance();

// check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    redirect_with_message("index", "You are already logged in");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // check if two passwords are equal
    if ($_POST["password"] !== $_POST["pswd"]) {
        redirect_with_message("register", "Passwords do not match");
    }

    $errors = [];
    $data = $_POST;
    $errors = validate_fields("register", $data);

    if (count($errors) > 0) {
        $logger->warning("Invalid fields registration", ['session_id' => session_id(), 'errors' => $errors, 'data' => $data]);
        redirect_with_message("register", "Invalid fields");
    }

    // CSRF token check
    if(!verify_and_regenerate_csrf_token($_POST['csrf'])){
        $logger->warning("CSRF tokens do not match", ['csrf' => $_POST['csrf']]);
        redirect_to_page("register");
    }

    // check the username
    $db = DBManager::getInstance();
    $query = "SELECT * FROM users WHERE username = ?";
    $params = [$_POST['username']];
    $param_types = "s";
    $result = $db->execute_query($query, $params, $param_types);

    if (!empty($result)) {
        redirect_with_message("register", "Username not valid");
    }

    // check the email
    $query = "SELECT * FROM users WHERE email = ?";
    $params = [$_POST['email']];
    $param_types = "s";
    $result = $db->execute_query($query, $params, $param_types);

    if (!empty($result)) {
        redirect_with_message("register", "Email not valid");
    }

    // all check passed, now insert the user
    $query = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
    $params = [$_POST["email"], $_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT)];
    $param_types = "sss";
    $result = $db->execute_query($query, $params, $param_types);

    if ($result > 0) {
        // Log user registration
        $logger = Log::getInstance();
        $logger->info("User registration", ['username' => $_POST["username"]]);

        redirect_to_page("login");
    } else {
        redirect_with_message("register", "Impossible to create user");
    }
}

require '../frontend/register.php';