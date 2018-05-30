<?php
	header('Content-type: application/json');
    require_once("../models/config.php");
	$status = array(
		'type'=>'success',
        'message'=> $lang['SUCCESS_MESSAGE']
	);

    $name = @trim(stripslashes($_POST['name']));
    $phone = @trim(stripslashes($_POST['phone']));
    $address = @trim(stripslashes($_POST['address']));
    $email = "Contact:" . @trim(stripslashes($_POST['email']));
    $subject = @trim(stripslashes($_POST['subject'])); 
    $message = @trim(stripslashes($_POST['message'])); 
    $email_from = $email;
    $email_to = 'support@hitchme.de';//replace with your email
    $body = 'Name: ' . $name . "\n" . 'Email: ' . $email . "\n" . 'Address: ' . $address . "\n". 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;
    if ($name != "" && $email!="" && $subject!="" && $message != "" ){
        $success = @mail($email_to, $subject, $body, 'From: <'.$email_from.'>');
    }
    echo json_encode($status);
    die;