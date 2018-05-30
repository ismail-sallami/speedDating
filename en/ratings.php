<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once ('head.php');
?>
<link href="css/input_radio.css" rel="stylesheet">

</head>
<body>

<?php
require_once 'header.php';
$userSprintsRow = fetchUserSprints($loggedInUser->user_id);
//Forms posted
if(!empty($_POST)) {
    //mark the sprint as decided
    if (!decideSprint($loggedInUser->user_id,$_POST['sprint_id'])){
        $errors[] = lang("SQL_ERROR");
    }

    $saving_error = 0;
    if(isset($_POST['matches']))
    foreach ($_POST['matches'] as $match) {

        $matching = saveMatch($_POST['sprint_id'], $loggedInUser->user_id, $match);
        $matchFound = checkMatches($_POST['sprint_id'], $loggedInUser->user_id, $match);
        //Send notification if there is a matching
        if ($matchFound == 1) {

            //fetch match details to get the email
            $matchDetails = fetchUserDetails(null, null, null, $match);
            //Send internal message to both users
            $matchMessage = sendInternalMessage($loggedInUser->username,null,lang('NEW_MATCH_TITLE'), lang('NEW_MATCH_BODY', array($matchDetails['user_name'])));
            $matchMessage = sendInternalMessage($matchDetails['user_name'],null,lang('NEW_MATCH_TITLE'), lang('NEW_MATCH_BODY', array($loggedInUser->username)));


            //sendInternalMessage($matchDetails['user_name'], null, $lang['NEW_MATCH_TITLE'], lang('NEW_MATCH_BODY',array($loggedInUser->username)));
            //sendInternalMessage($loggedInUser->username, null, $lang['NEW_MATCH_TITLE'],lang('NEW_MATCH_BODY',array($matchDetails['user_name'])));


            //Setup our custom hooks
            $hooks = array(
                "searchStrs" => array("#USERNAME#","#MATCH2#","#IDMATCH2#"),
                "subjectStrs" => array($loggedInUser->username, $matchDetails['user_name'],  $matchDetails['id'] )
            );
            $mail = new userCakeMail();
            if (!$mail->newTemplateMsg("matching-notification.html", $hooks)) {
                $errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
            } else {
                if (!$mail->sendMail($loggedInUser->email, "New match")) {
                    $errors[] = lang("MAIL_ERROR");

                } else {
                    $successes[]  = lang("CONGRATULATION_MATCH_FOUND");
                    //Send email to the second match
                    $hooks = array(
                        "searchStrs" => array("#USERNAME#","#MATCH2#","#IDMATCH2#"),
                        "subjectStrs" => array($matchDetails['user_name'], $loggedInUser->username , $loggedInUser->user_id )
                    );
                    $mail->newTemplateMsg("matching-notification.html", $hooks);
                    $mail->sendMail($matchDetails['email'], "New match");
                }

            }
        }

            if ($matching == false) {
                $saving_error++;
            }
        }
        if ($saving_error > 0) {
            $errors[] = lang("SQL_ERROR");
        } else {
            $successes[] = lang("RATES_SAVED");

        }
}
?>
    <section id="portfolio">
        <div class="container">
            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 ">
                <?= resultBlock($errors,$successes) ?>

                <?php
                if (!$userSprintsRow){
                    echo '<div class="alert alert-warning">'.lang('NO_SPRINT_YET').'</div>';
                }else {

                ?>
                <div class="tab-wrap">
                    <div class="media">

                            <div class="parrent pull-left">
                                <ul class="nav nav-tabs nav-stacked">
                                    <?php
                                    $active = 0;
                                    foreach ($userSprintsRow as $sprint) {
                                        echo '<li class=" ' . ($active ? '' : 'active') . ' "><a href="#' . $sprint['sprint_id'] . '" data-toggle="tab" class="analistic-01">' . $sprint['sprint_date'] . ' : ' . date('g:ia', strtotime($sprint['sprint_time'])) . '</a></li>';
                                        $active++;
                                    }
                                    ?>
                                </ul>
                            </div
                        <div class="parrent media-body">
                            <div class="tab-content">
                                <?php
                                $active=0;
                                foreach ($userSprintsRow as $sprint) {
                                    echo '<div class="tab-pane fade ' .($active ? '':'active in').'" id="'.$sprint['sprint_id'].'">
                                            <div class="media">
                                                <div class="media-body">
                                                <form method="POST">';
                                    $decided = getSprintDecision($loggedInUser->user_id,$sprint['sprint_id']);
                                    if ($decided=="yes"){
                                        echo '<div class="mask"></div>';
                                    }
                                    $participants = fetchSprintParticipants($sprint['sprint_id']);
                                    $countMatch = 0;
                                    foreach ($participants as $participant) {
                                        if ($participant['user_id'] != $loggedInUser->user_id){
                                            $rating_checked='';
                                            if (checkMatches ($sprint['sprint_id'], $loggedInUser->user_id, $participant['user_id'])>0)
                                                $rating_checked='checked';
                                            echo '  <div class="media testimonial-inner">

                                                    <div class="pull-left">
                                                        <img class="img-responsive img-circle" height="150" width="100" src="images/profiles/'. $participant['user_id'] .'/'. $participant['profile_pic'] .'">
                                                    </div>
                                                    <div class="media-body">
                                                        <p><a href="profile.php?id='.$participant['user_id'].'"><strong>'.$participant['fname'] .'</strong></a></p>
                                                        <div class="btn-group" data-toggle="buttons">
                                                            <label class="btn">
                                                            <input type="checkbox" name="matches[]" value="'.$participant['user_id'] .'" ' . $rating_checked .'><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> '. lang('I_LIKE') .'</span></label>                                                        </div>
                                                        </div>
                                                     </div>
                                                ';
                                        }

                                        $countMatch++;
                                    }
                                    if ($decided=="no"){
                                        echo '<input type="submit" class="submit btn btn-primary btn-lg pull-right" value="Submit">';
                                    }
                                    echo         ' <input type="hidden" name="sprint_id" value="'.$sprint['sprint_id'].'">

                                                    </form>
                                                </div><!--media-body-->
                                            </div><!--media-->
                                          </div><!--tab-pane-->

                                            ';

                                    $active++;
                                }
                                ?>
                            </div> <!--/.tab-content-->
                        </div> <!--/.media-body-->
                    </div> <!--/.media-->
                </div><!--/.tab-wrap-->
                <?php
                }
                ?>

            </div><!--/.col-sm-6-->



        </div>
    </section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>


</body>
</html>
