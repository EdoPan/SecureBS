<?php

require_once './utils/db_manager.php';
include_once 'utils/utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validate input fields
    $errors = array();
    $data = $_POST;
    $errors = validate_fields("validate", $data);

    if (count($errors) > 0) {
        redirect_with_message("validate", "Invalid fields");
    }

    // check if the user exists
    $db = DBManager::getInstance();
    $query = "SELECT * FROM recovery_number WHERE username = ? AND operation = 'login' AND request_time >= NOW() - INTERVAL 15 MINUTE";
    $params = [$_POST['username']];
    $param_types = "s";
    $result = $db->execute_query($query, $params, $param_types);

    if(empty($result)) {
        redirect_with_message("login", "Number is discarded");
    }

    $inserted_number = $_POST['number'];
    $correct_number = $result[0]['number'];

    if($inserted_number == $correct_number){
        $query = "DELETE FROM recovery_number WHERE username = ? AND operation='login'";
        $params = [$_POST['username']];
        $param_types = "s";
        $db->execute_query($query, $params, $param_types);

        $query = "UPDATE users SET need_verification=0 WHERE username = ?";
        $params = [$_POST['username']];
        $param_types = "s";
        $db->execute_query($query, $params, $param_types);
        redirect_to_page("index");
    } else {
        redirect_with_message("validate", "Invalid number");
    }

}