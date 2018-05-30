<?php
require_once("../models/config.php");
$toRemind = listToRemind();

$mail = new userCakeMail();
foreach ($toRemind as $remind) {

    $hooks = array(
        "searchStrs" => array("#SPRINTDATE#","#SPRINTTIME#","#SPRINTLANGUAGE#", "#SPRINTLOCATION#","#USERNAME#"),
        "subjectStrs" => array($remind['date'],$remind['time'],$remind['lang'],$remind['location'],$remind['fname'])
    );
    $template = "booking-remind-". $remind['lang'] .".html";

    if(!$mail->newTemplateMsg($template,$hooks))
    {
        $errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
    }
    else
    {
        if(!$mail->sendMail($remind['email'],"HitchMe Speed-date"))
        {
            $errors[] = lang("MAIL_ERROR");
        }

    }
}
