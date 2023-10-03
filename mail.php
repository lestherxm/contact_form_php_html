<?php
require_once __DIR__ . '/vendor/autoload.php';
// Needed to be able to use evironment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

use PHPMailer\PHPMailer\PHPMailer;

function sendMail($subject, $body, $email, $name, $html = false){
    
    //Create an instance; passing `true` enables exceptions
    $phpmailer = new PHPMailer(true);
    
    // Initial settings for our email sever (in this case, mailtrap)
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.gmail.com';
    $phpmailer->SMTPAuth = true;
    $phpmailer->CharSet = PHPMailer::CHARSET_UTF8;
    $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    $phpmailer->Port = 465;
    $phpmailer->Username = $_ENV['MAIL_USER'];
    $phpmailer->Password = $_ENV['MAIL_PASS'];
    
    // Adding recipient
    $phpmailer->setFrom($_ENV['MAIL_USER'], $_ENV['MAIL_NAME']); //quien envia
    $phpmailer->addAddress($email, $name);//quien recibe

    // Email's Content
    $phpmailer->isHTML($html);                                  //Set email format to HTML
    $phpmailer->Subject = $subject;
    $phpmailer->Body    = $body;

    // Senting the email itself
    $phpmailer->send();

}

?>