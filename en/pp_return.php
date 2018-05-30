<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once ('head.php');

?>

</head>
<body>

<?php
require_once 'header.php';
?>
<section id="portfolio">
    <div class="container">
        <?php

        switch ($_GET['result']){
            case "cancel":
                echo "<div class='alert alert-danger'>" . $lang['PP_PAYMENT_CANCELLED'] ."</div>";
                break;
            case "success": {
                switch ($_POST['payment_status']){
                    case "Completed":
                    case "Created":
                    case "Processed":
                        echo "<div class='alert alert-success'>" . $lang['PP_PAYMENT_ACCEPTED'] ."</div>";
                        proceed_booking();
                        break;
                    case "Pending":
                        echo "<div class='alert alert-warning'>" . $lang['PP_PAYMENT_PENDING'] ."</div>";
                        break;
                    case "denied":
                        echo "<div class='alert alert-danger'>" . $lang['PP_PAYMENT_DENIED'] ."</div>";
                        break;
                    default:
                        echo "<div class='alert alert-danger'>" . $lang['PP_PAYMENT_ERROR'] ."</div>";
                        break;
                }
                break;
            }
            default:
                echo "<div class='alert alert-danger'>" . $lang['PP_PAYMENT_ERROR'] ."</div>";
                break;
        }

        function proceed_booking(){
            parse_str($_POST['custom'],$paypalData);
            $user_id = $paypalData['user_id'];
            $sprint_id = $paypalData['sprint_id'];
            $guest_id = $paypalData['guest_id'];

            //email confirmation to user and admin
            $mail = new userCakeMail();
            //user datails
            $user = fetchUserProfile($user_id);
            //sprint detail
            $sprint = fetchSprint($sprint_id);

            //If invitation
            if($guest_id){
                $guestProfile = fetchUserProfile($guest_id);
                $guestDetails = fetchUserDetails(null, null, null, $guest_id);

                //For invitation
                //Setup our custom hooks
                $hooks = array(
                    "searchStrs" => array("#GUEST#", "#GUEST_ID#","#GUEST_PIC#", "#INVITING#","#INVITING_ID#","#INVITING_PIC#", "#SPRINTDATE#", "#SPRINTTIME#", "#SPRINTLOCATION#", "#SPRINTLANGUAGE#", "#TOKEN#"),
                    "subjectStrs" => array($guestProfile['fname'], $guestProfile['user_id'],$guestProfile['profile_pic'], $user['fname'] . ' ' .$user['lname'],  $user['user_id'], $user['profile_pic'], $sprint['date'], $sprint['time'], $sprint['location'] . ' ' . $sprint['city'], $sprint['sprint_lang'], $guestDetails['activation_token'])
                );
                if (!$mail->newTemplateMsg("invitation-notification.html", $hooks)) {
                    $errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
                } else {
                    if (!$mail->sendMail($guestDetails['email'], "Speeddating invitation")) {
                        $errors[] = lang("MAIL_ERROR");

                    } else {
                        $successes[] = lang("INVITATION_SENT", array($guestProfile['fname']));
                    }
                }
            }else{
                //If single booking
                $sprint_booked = bookSprint($user_id, null, $sprint_id);
                $hooks = array(
                    "searchStrs" => array("#SPRINTDATE#","#SPRINTTIME#","#SPRINTLANGUAGE#", "#SPRINTLOCATION#","#USERNAME#"),
                    "subjectStrs" => array($sprint['date'],$sprint['time'],$sprint['sprint_lang'],$sprint['location'],$user['fname'])
                );

                if(!$mail->newTemplateMsg("booking-confirmation.html",$hooks))
                {
                    $errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
                }
                else
                {
                    if(!$mail->sendMail($loggedInUser->email,"Hitchme Booking"))
                    {
                        $errors[] = lang("MAIL_ERROR");
                    }
                    else
                    {
                        $successes[]  = lang("FORGOTPASS_NEW_PASS_EMAIL");
                    }
                }
            }
        }

        ?>
    </div>
</section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>


</body>
</html>
