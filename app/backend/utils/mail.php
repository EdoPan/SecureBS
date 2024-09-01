<?php
require_once __DIR__ . '/logger.php';
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

function send_mail($email, $name, $subject, $message) : bool {    
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
    $mail = new PHPMailer(true);

    try {
        //enable verbose debug output (2 for detailed debug output)
        //$mail->SMTPDebug = 2;

        //using the SMTP protocol to send the email
        $mail->isSMTP();

        $mail->Host     = 'smtp.gmail.com';
        $mail->Username = $_ENV['MAIL_ADDRESS'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];

        //by setting SMTPSecure to PHPMailer::ENCRYPTION_STARTTLS
        //we are telling PHPMailer to use TLS encryption method 
        //when connecting to the SMTP server. This helps ensure
        //that the communication between our application and the
        //SMTP server is encrypted.
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->SMTPAuth = true;

        //TCP port to connect with Gmail SMTP server.
        $mail->Port = 587;

        //sender information
        $mail->setFrom($mail->Username, 'Secure Book Store');

        //receiver email address and name
        $mail->addAddress($email, $name);  

        //by setting isHTML(true), we inform PHPMailer that the
        //email will include HTML markup.
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $message;

        // Attempt to send the email
        if (!$mail->send()) {
            $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }

        return true;
    } catch (Exception $e) {
        $error = "Message could not be sent. Mailer Error: {$e->getMessage()}";
        return false;
    }

}

function send_verification_code($username, $mail){
    // generate the random number
    $randomNumber = 0;
    try {
        $randomNumber = random_int(1, 1000000000); 
    } catch (Exception $e) {
        //echo "Errore nella generazione del numero casuale: ", $e->getMessage();
        redirect_with_message("login", "Error, retry later");
    }

    // save the generated number
    $query = "INSERT INTO recovery_number (username, number, operation) VALUES (?, ?, ?)";
    $params = [$username, $randomNumber, "login"];
    $params_types = "sis";

    $db = DBManager::getInstance();
    $db->execute_query($query, $params, $params_types);

    // send the email to the user
    $subject = "Secure Book Store - Login Validation";
    $message = "Hello $username, <br> We've sended to you an email with a number, please insert the number in the form to validate your profile <br> Number: $randomNumber";

    send_mail($mail, $username, $subject, $message);

    $logger = Log::getInstance();
    $logger->info("Verification code sended", ['username' => $username, 'random_number' => $randomNumber]);

}

function send_change_password_code($username, $mail){
    // generate the random number
    $randomNumber = 0;
    try {
        $randomNumber = random_int(1, 1000000000); 
    } catch (Exception $e) {
        //echo "Errore nella generazione del numero casuale: ", $e->getMessage();
        redirect_with_message("login", "Error, retry later");
    }

    // save the generated number
    $query = "INSERT INTO recovery_number (username, number, operation) VALUES (?, ?, ?)";
    $params = [$username, $randomNumber, "change"];
    $params_types = "sis";

    $db = DBManager::getInstance();
    $db->execute_query($query, $params, $params_types);

    // send the email to the user
    $subject = "Secure Book Store - Change Password";
    $message = "Hello $username, <br> We've sended to you an email with a number, please insert the number in the form to change the password <br> Number: $randomNumber";

    send_mail($mail, $username, $subject, $message);

    $logger = Log::getInstance();
    $logger->info("Change code sended", ['username' => $username, 'random_number' => $randomNumber]);
}

function send_recover_password_code($username, $mail){
    // generate the random number
    $randomNumber = 0;
    try {
        $randomNumber = random_int(1, 1000000000); 
    } catch (Exception $e) {
        //echo "Errore nella generazione del numero casuale: ", $e->getMessage();
        redirect_with_message("login", "Error, retry later");
    }

    // save the generated number
    $query = "INSERT INTO recovery_number (username, number, operation) VALUES (?, ?, ?)";
    $params = [$username, $randomNumber, "recover"];
    $params_types = "sis";

    $db = DBManager::getInstance();
    $db->execute_query($query, $params, $params_types);

    // send the email to the user
    $subject = "Secure Book Store - Change Password";
    $message = "Hello $username, <br> We've sended to you an email with a number, please insert the number in the form to change the password <br> Number: $randomNumber";

    send_mail($mail, $username, $subject, $message);

    $logger = Log::getInstance();
    $logger->info("Recover code sended", ['username' => $username, 'random_number' => $randomNumber]);
}