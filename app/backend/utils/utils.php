<?php

include_once "validation.php";
include_once "navigation.php";


$regexes = [
    'firstname' => "/[\\-'A-Z a-zÀ-ÿ]+",
    'lastname' => "/[\\-'A-Z a-zÀ-ÿ]+",
    'address' => "/[\\-'A-Z a-zÀ-ÿ0-9.,]+",
    'city' => "/[\\-'A-Z a-zÀ-ÿ.]+",
    'postalcode' => "\d+",
    'country' => "[\\-'A-Z a-z]+",
    'cardnumber' => "\b\d{4}[\\- ]?\d{4}[\\- ]?\d{4}[\\- ]?\d{4}\b",
    'cvv' => "\d{3}",
    'username' => "/^[a-zA-Z0-9]{3,20}$/",
    'password' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
    'email' => "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",
];

$page_regexes = [
    "register" => [
        "username" => $regexes['username'],
        "password" => $regexes['password'],
        "pswd" => $regexes['password'],
        "email" => $regexes['email'],
    ],
    "login" => [
        "username" => $regexes['username'],
        "password" => $regexes['password'],
    ],
];