<?php 

    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    // Load Composer's autoloader
    require './../../dashboard/vendor/autoload.php';

    require('../Config/DBconfig.php');

    date_default_timezone_set('America/Mexico_City');
    $date = date("Y-m-d H:i:s", strtotime($_POST['date']));

    

    // echo $pass;

    
    
        $updateticket="UPDATE `tbl_tickets` 
        SET `userid`='".$_POST['userid']."', `fechapago`='".$date."', `idticket`='".$_POST['idticket']."', `nombre`='".$_POST['name']."', `status`='1' 
        WHERE idinvoice='".$_POST['idinvoice']."'";
        
        $addticket=$basededatos->connect()->prepare($updateticket);
        $addticket->execute();

        // echo json_encode($updateticket);

        // echo $updateticket.'<br>';


        // echo "SELECT * FROM tbl_tickets WHERE idinvoice='".$_POST['idinvoice']."'";
        $getinvoice=$basededatos->connect()->prepare("SELECT * FROM tbl_tickets WHERE idinvoice='".$_POST['idinvoice']."'");
        $getinvoice->execute();
    
        $invoice=$getinvoice->fetch(PDO::FETCH_ASSOC);
        
        
        

        $mail = new PHPMailer(true);
        $mail->CharSet='UTF-8';
        $mail->Encoding = 'base64';
            
        $mail->isSMTP();                                        
        $mail->Host       = 'smtp.gmail.com';          
        $mail->SMTPAuth   = true;                               
        $mail->Username   = 'virtualdanceacademy@eurosonlatino.com.mx';     
        $mail->Password   = 'Cel9858265';                        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
        $mail->Port       = 587;                                    
        // $mail->SMTPDebug = 4;
        $mail->setFrom('virtualdanceacademy@eurosonlatino.com.mx', 'Euroson Latino');
        $body = file_get_contents('./../../dashboard/mails/accessovsdc.html');
        $body = str_replace('$usuariop', $invoice['email'], $body);
        $body = str_replace('$passwordp', $invoice['password'], $body);
        $body = str_replace('$nombre_p', $invoice['fname'], $body); 
        $body = str_replace('$apellidos_p', $invoice['lname'], $body);
        $body = str_replace('$dancerselect', $invoice['namedancer'], $body);
        $body = str_replace('$emailp', $invoice['email'], $body);
        $body = str_replace('$invoiceidp', $_POST['idinvoice'], $body);
        $body = str_replace('$ticketidp', $_POST['idticket'], $body);

        $body = preg_replace('/\\\\/','', $body);
        $mail->MsgHTML($body);
        //$mail->AddAddress($invoice['email']);
        $mail->AddAddress($_POST['email'], $invoice['fname'].' '.$invoice['lname']);
        $mail->AddCC($invoice['email'], $invoice['fname'].' '.$invoice['lname']);
        $mail->addBCC('bryan.martinez.romero@gmail.com');
        $mail->isHTML(true);

        $mail->Subject = 'Este es tu acceso - Virtual Salsa Dance Competition';
        
        
        if($mail->send()){
            echo json_encode($invoice);
        }else{
            header("HTTP/1.1 404 Not Found");
        }
        
        
        
        
        

   
?>