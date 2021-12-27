<?php
include "./PHPMailer-5.2.26/class.smtp.php";
include "./PHPMailer-5.2.26/class.phpmailer.php";

function sendMail($title, $content, $nFrom, $mFrom, $mPass, $nTo, $mTo,$diachicc=''){
    // $nFrom = 'UnicornStore';
    // $mFrom = 'unicornstore512@gmail.com';  //dia chi email cua ban 
    // $mPass = 'Liemunicorn512';       //mat khau email cua ban
    $mail             = new PHPMailer();
    $body             = $content;
    $mail->IsSMTP(); 
    $mail->CharSet   = "utf-8";
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;                    // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";        
    $mail->Port       = 465;
    $mail->Username   = $mFrom;  // GMAIL username
    $mail->Password   = $mPass;               // GMAIL password
    $mail->SetFrom($mFrom, $nFrom);
    //chuyen chuoi thanh mang
    $ccmail = explode(',', $diachicc);
    $ccmail = array_filter($ccmail);
    if(!empty($ccmail)){
        foreach ($ccmail as $k => $v) {
            $mail->AddCC($v);
        }
    }
    $mail->Subject    = $title;
    $mail->MsgHTML($body);
    $address = $mTo;
    $mail->AddAddress($address, $nTo);
    $mail->AddReplyTo('unicornstore512@gmail.com', 'UnicornStore');
    if(!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}
?>