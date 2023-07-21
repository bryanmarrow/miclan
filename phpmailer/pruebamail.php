<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';


// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer();



$mail->CharSet = 'UTF-8';
$mail->Encoding = '8bit';
// $mail->Encoding = 'base64';

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'bryan.martinez@tractozone.com.mx';                     // SMTP username
    $mail->Password   = 'trzone-b1554';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                // TCP port to connect to
    
    $mail->SMTPDebug = 3;

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress('bryan.martinez.romero@gmail.com', 'Joe User');     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    
    // $someSubjectWithTildes = ;

    
    // $mailer->Encoding = 'quoted-printable';
    // $mailer->Subject = html_entity_decode('Subscripción España');
    

    // $subject='Registro - Imperio México';
    $mail->Subject = 'Registro - Imperio México';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>