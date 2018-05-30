<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once ('head.php');

//User has denied this request
if(!empty($_GET["refuse"]))
{
    $mail = new userCakeMail();
    $token = trim($_GET["refuse"]);
    $inviting_id = trim($_GET["inviting"]);
    $inviting_details = fetchUserDetails(null, null, null, $inviting_id);
    $guest_details = fetchUserDetails(null, null,$token );
    $guest_profile = fetchUserProfile($guest_details['id']);

    //Verify token
    if($token == "" || !validateActivationToken($token,NULL, TRUE))
    {
        $errors[] = lang("FORGOTPASS_INVALID_TOKEN");
    }
    else
    {
        //Sent email to the inviting person to inform about the refuse
        $hooks = array(
            "searchStrs" => array("#GUEST#"),
            "subjectStrs" => array($guest_profile['fname'])
        );

        if(!$mail->newTemplateMsg("invitation_refused.html",$hooks))
        {
            $errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
        }
        else
        {
            /*var_dump($inviting_details);*/
            if(!$mail->sendMail($inviting_details['email'],"Hitchme Booking"))
            {
                $errors[] = lang("MAIL_ERROR");
            }
            else
            {
                $successes[]  = lang("INVITATION_RESPOND");
            }
        }
    }
}
?>
</head>
<body>
<?php
require_once 'header.php';
?>
    <section id="portfolio">
        <div class="container">
            <?= resultBlock($errors,$successes); ?>
        </div>
    </section><!--/#portfolio-item-->
<?php
require_once 'footer.php';
?>
</body>
</html>
