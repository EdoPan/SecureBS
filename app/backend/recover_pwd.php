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
    $errors = validate_fields("recover_pwd", $data);

    if (count($errors) > 0) {
        $logger->warning("Invalid fields in password recovery", ['session_id' => session_id(), 'errors' => $errors, 'data' => $data]);
        redirect_with_message("login", "Invalid fields");
    }

    // CSRF token check
    if(!verify_and_regenerate_csrf_token($_POST['csrf'])){
        $logger->warning("CSRF tokens do not match", ['csrf' => $_POST['csrf']]);
        redirect_to_page("index");
    }

    $username = $_POST['username'];
    $inserted_number = $_POST['number'];
    $pwd = $_POST['pwd'];
    $new_pwd = $_POST['new_pwd'];

    // check if the two passwords are equal
    if ($new_pwd !== $pwd) {
        redirect_with_message("login", "The passwords do not match");
    }

    // check if the user exists
    $db = DBManager::getInstance();
    $query = "SELECT * FROM users WHERE username = ?";
    $params = [$username];
    $param_type = "s";
    $result = $db->execute_query($query, $params, $param_type);

    if (empty($result)) {
        redirect_with_message("login", "Error while retrieving user data");
    }
    $current_pwd = $result[0]["password"];

    // user exists, check if the number is correct
    $query = "SELECT * FROM recovery_number WHERE username = ? AND operation = 'recover' AND request_time >= NOW() - INTERVAL 15 MINUTE";
    $params = [$username];
    $param_types = "s";
    $result = $db->execute_query($query, $params, $param_types);

    if (empty($result)) {
        $logger->warning("User inserted an expired number during password recovery", ['session_id' => session_id(), 'username' => $_POST['username']]);
        redirect_with_message("login", "Number is discarded");
    }
    $correct_number = $result[0]['number'];
    if ($inserted_number != $correct_number) {
        redirect_with_message("login", "Invalid number");
    }

    // check if the new password is different from the current one
    $password_corrected = password_verify($pwd, $current_pwd);
    if ($password_corrected) {
        redirect_with_message("recover", "Error while password check");
    }

    // if all checks pass, update the password
    $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);
    $query = "UPDATE users SET password=? WHERE username = ?";
    $params = [$hashed_password,$username];
    $param_type = "ss";
    $db->execute_query($query, $params, $param_type);

    $query = "DELETE FROM recovery_number WHERE username = ? AND operation='recover'";
    $params = [$username];
    $param_types = "s";
    $db->execute_query($query, $params, $param_types);


    $logger->info("User correctly changed the password", ['username' => $username]);

    redirect_to_page("login");
}

require_once '../frontend/recover_pwd.php';