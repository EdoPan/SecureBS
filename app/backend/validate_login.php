<?php
require_once './utils/db_manager.php';
require_once './utils/logger.php';
include_once 'utils/utils.php';
require_once './utils/csrf.php';

$logger = Log::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validate input fields
    $errors = [];
    $data = $_POST;
    $errors = validate_fields("validate", $data);

    if (count($errors) > 0) {
        $logger->warning("Invalid fields in user verification for login", ['session_id' => session_id(), 'errors' => $errors, 'data' => $data]);
        redirect_with_message("validate", "Invalid fields");
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

    // check if the user exists
    $db = DBManager::getInstance();
    $query = "SELECT * FROM recovery_number WHERE username = ? AND operation = 'login' AND request_time >= NOW() - INTERVAL 15 MINUTE";
    $params = [$_POST['username']];
    $param_types = "s";
    $result = $db->execute_query($query, $params, $param_types);

    if (empty($result)) {
        $logger->warning("User inserted an expired number during validation process", ['session_id' => session_id(), 'username' => $_POST['username']]);
        redirect_with_message("login", "Number is discarded");
    }

    $inserted_number = $_POST['number'];
    $correct_number = $result[0]['number'];

    if ($inserted_number == $correct_number) {
        $query = "DELETE FROM recovery_number WHERE username = ? AND operation='login'";
        $params = [$_POST['username']];
        $param_types = "s";
        $db->execute_query($query, $params, $param_types);

        $query = "UPDATE users SET need_verification=0 WHERE username = ?";
        $params = [$_POST['username']];
        $param_types = "s";
        $db->execute_query($query, $params, $param_types);

        $logger->info("User inserted a valid number", ['session_id' => session_id(), 'username' => $_POST['username'], 'number' => $inserted_number]);

        redirect_to_page("index");
    } else {
        $logger->warning("User inserted an invalid number", ['session_id' => session_id(), 'username' => $_POST['username'], 'number' => $inserted_number]);
        redirect_with_message("validate", "Invalid number");
    }
}

require '../frontend/validate_login.php';