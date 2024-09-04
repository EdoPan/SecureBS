<?php
require_once './utils/db_manager.php';
require_once './utils/logger.php';
include_once 'utils/utils.php';
require './utils/config.php';

$logger = Log::getInstance();

// check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    redirect_with_message("index", "You are already logged in");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // validate input fields
    $errors = [];
    $data = $_POST;
    $errors = validate_fields("login", $data);

    if (count($errors) > 0) {
        $logger->warning("Invalid fields login", ['session_id' => session_id(), 'errors' => $errors, 'data' => $data]);
        redirect_with_message("login", "Invalid fields");
    }

    // check if the user exists
    $db = DBManager::getInstance();
    $query = "SELECT * FROM users WHERE username = ?";
    $params = [$_POST['username']];
    $param_types = "s";
    $result = $db->execute_query($query, $params, $param_types);

    if (empty($result)) {
        redirect_with_message("login", "User not found");
    }

    $username = $result[0]["username"];
    $mail = $result[0]["email"];
    $correct_password = $result[0]["password"];
    $user_id = $result[0]["id"];

    if ($result[0]["need_verification"] === 1){
        send_verification_code($username, $mail);
        redirect_to_page("validate_login");
        exit();
    }

    // check number of attempts of the user
    $query = "SELECT * FROM login_attempts WHERE attempt_time >= NOW() - INTERVAL 2 MINUTE;";
    $result = $db->execute_query($query);
    $attempts = count($result);


    $password_corrected = password_verify($_POST['password'], $correct_password);

    if ($password_corrected === true) {
        $_SESSION['user_id'] = $user_id;
        //session_regenerate_id(true);
    } else {
        // password is incorrect, insert the attempt in the DB
        $query = "INSERT INTO login_attempts (username) VALUES (?)";
        $params = [$_POST['username']];
        $param_types = "s";
        $db->execute_query($query, $params, $param_types);
        $attempts += 1;
        if ($attempts > 4) {  
            send_verification_code($username, $mail);
            redirect_to_page("validate_login");
            exit();
        }
        $logger->warning("User inserted a wrong password", ['username' => $_POST['username']]);
        redirect_with_message("login", "Password is incorrect");
    }
    /*
    // check if it's needed to regenrate the session id
    if (!isset($_SESSION['last_generated'])) {
        $_SESSION['last_generated'] = time();
    }

    if (time() - $_SESSION['last_generated'] > 600) {
        session_regenerate_id(true);
        $_SESSION['last_generated'] = time();
    }
    */

    // Log user log-in
    $logger->info("User logged in", ['username' => $_POST["username"], 'session_id' => session_id()]);
    
    redirect_to_page("index");
}

require '../frontend/login.php';