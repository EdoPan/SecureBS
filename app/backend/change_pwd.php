<?php
require_once './utils/db_manager.php';
require_once './utils/logger.php';
include_once 'utils/utils.php';
require './utils/config.php';

$logger = Log::getInstance();

// check if the user is already logged in
if (!isset($_SESSION['user_id'])) {
    redirect_with_message("login", "You are not logged in");
    exit;
}

if (!isset($_SESSION['new_pswd'])) {
    redirect_with_message("login", "You are not logged in");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validate input fields
    $errors = [];
    $data = $_POST;
    $errors = validate_fields("validate_change_pwd", $data);

    if (count($errors) > 0) {
        $logger->warning("Invalid fields during password change", ['session_id' => $_SESSION['id'], 'user_id' => $_SESSION['user_id'], 'errors' => $errors, 'data' => $data]);
        redirect_to_page("profile");
    }

    // check if the user exists
    $db = DBManager::getInstance();
    $query = "SELECT * FROM users WHERE id = ?";
    $params = [$_SESSION['user_id']];
    $param_types = "i";
    $result = $db->execute_query($query, $params, $param_types);

    if (empty($result)) {
        redirect_with_message("profile", "Error while retrieving user data");
    }

    $number = $_POST["number"];
    $username = $result[0]["username"];

    $query = "SELECT * FROM recovery_number WHERE username = ? AND operation = 'change' AND request_time >= NOW() - INTERVAL 15 MINUTE";
    $params = [$username];
    $param_types = "s";
    $result = $db->execute_query($query, $params, $param_types);

    if (empty($result)) {

        $logger->warning("User tried to change password with an expired number", ['username' => $username, 'number' => $number]);

        redirect_with_message("login", "Number is discarded");
    }

    $correct_number = $result[0]['number'];
    $new_pwd = $_SESSION["new_pswd"];
    // print correct_number and number
    echo "correct_number: $correct_number, number: $number";
    if ($number == $correct_number) {
        $query = "DELETE FROM recovery_number WHERE username = ? AND operation='change'";
        $params = [$username];
        $param_types = "s";
        $db->execute_query($query, $params, $param_types);

        $query = "UPDATE users SET password=? WHERE username = ?";
        $params = [$new_pwd, $_POST['username']];
        $param_types = "ss";
        $db->execute_query($query, $params, $param_types);

        $logger->info("User succesfully changed password", ['username' => $username]);
        
        redirect_to_page("index");
    } else {
        $logger->warning("User inserted an invalid number during changed password", ['username' => $username, 'wrong_number' => $number, 'correct_number' => $correct_number]);

        redirect_with_message("change_pwd", "Invalid number, correct_number: $correct_number, number: $number");
    }
}

require '../frontend/change_pwd.php';