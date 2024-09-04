<?php
require_once './utils/db_manager.php';
require_once './utils/logger.php';
include_once 'utils/utils.php';
require './utils/config.php';

$logger = Log::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validate input fields
    $errors = [];
    $data = $_POST;
    $errors = validate_fields("recover", $data);

    if (count($errors) > 0) {
        $logger->warning("Invalid fields for account recovery", ['session_id' => session_id(), 'errors' => $errors, 'data' => $data]);
        redirect_with_message("login", "Invalid fields");
    }

    // check if the user exists
    $db = DBManager::getInstance();
    $query = "SELECT * FROM users WHERE email = ?";
    $params = [$_POST['email']];
    $param_types = "s";
    $result = $db->execute_query($query, $params, $param_types);

    if (empty($result)) {
        redirect_with_message("login", "Error while retrieving user data");
    }

    $username = $result[0]["username"];
    $email = $result[0]["email"];

    send_recover_password_code($username, $email);
    $logger->info("User requested a password recovery", ['username' => $username]);

    redirect_to_page("recover_pwd");
}

require '../frontend/start_recover.php';