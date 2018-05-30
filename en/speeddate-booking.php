<?php
require_once("../models/config.php");
if(isUserLoggedIn()) {
    unset($_SESSION['referer']);
}else{
    $_SESSION["referer"] = $_SERVER['REQUEST_URI'];
}
if (!securePage($_SERVER['PHP_SELF'])){die();}
//Not logged in user will be redirected to login or registrate

//if no sprint (direct access), foreword to error page
try {
    if (isset($_POST['guest'])){
        //If it is an invitation
        $sprint_id =$_POST['sprint'];
        $guest_id= $_POST['guest'];
        $guest_details = fetchUserProfile($guest_id);
        $user_details = fetchUserProfile($loggedInUser->user_id);
    }else{
        //If it is a single booking
        $sprint_id =$_GET['sprint'];
        $guest_id = NULL;
    }
    $sprint =fetchSprint($sprint_id);
    $gender = getGender($loggedInUser->user_id);

    if($gender){
        //If it is a single booking, test the availability
        if ($guest_id === NULL){
            if ($gender=="male"){
                if ($sprint['m_available'] == $sprint['m_booked']){
                    $error = $lang['NO_MORE_MEN'];
                }
            }else{
                if ($sprint['w_available'] == $sprint['w_booked']){
                    $error = $lang['NO_MORE_WOMEN'];
                }
            }
        }
    }else{
        $error =  $lang['EMPTY_PROFILE'];
    }
    if(!$sprint){
        header('Location: error.php'); die();
    }
}

//catch exception
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}
require_once ('head.php');

//preparing CUSTOM var for Paypal
$PaypalData="sprint_id=".$sprint_id."&guest_id=".$guest_id."&user_id=".$loggedInUser->user_id;
?>
<title>HitchMe &hearts; Book your event</title>
<meta name="keywords" content="SpeedDating, event, event booking, speed date booking, Berlin" />
<meta name="description" content="Select and book your event and join us to meet singles from the city.">

</head>
<body>

<?php
require_once 'header.php';
?>
    <section id="backgroundedDiv" class="transparent-bg">
        <div class="container" >
            <div id="innerBackgroundedDiv" class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-xs-12 col-xs-offset-0">
                <?php
                if (isset($error)){
                    echo '<br><div class="alert alert-warning"> <i class="icon icon-warning"></i> '. $error .'</div>';

                }else {

                    ?>
                    <div class="media">
                        <h2><?= lang('EVENT_DETAILS'); ?></h2>
                        <?php
                        if ($guest_id) {
                            echo '
                        <div class="center col-md-12">
                        <img class=" img-circle" height="150" width="150" src="images/profiles/' . $loggedInUser->user_id . '/' . $user_details['profile_pic'] . '">
                        <img class=" img-circle" height="150" width="150" src="images/profiles/' . $guest_id . '/' . $guest_details['profile_pic'] . '">
                        </div>
                        ';
                        }
                        ?>

                        <div class="col-md-2 col-xs-4">
                            <p><strong><?= $lang['DATE'] ?>: </strong></p>
                            <p><strong><?= $lang['TIME'] ?>: </strong></p>
                            <p><strong><?= $lang['LOCATION'] ?>: </strong></p>
                            <?php
                            if ($guest_id === NULL) {
                                ?>
                                <p><strong><?= $lang['AGE'] ?>: </strong></p>
                                <p><strong><?= $lang['LANGUAGE'] ?>: </strong></p>
                                <?php
                            }
                            ?>
                            <p><strong><?= $lang['FEE'] ?>: </strong></p>
                        </div>
                        <div class="col-md-4 col-xs-8">
                            <p><?= strftime("%a, %e %b %Y", date_create($sprint['date'])->getTimestamp()) ?></p>
                            <p><?= $sprint['time'] ?></p>
                            <p><?= $sprint['location'] ?></p>
                            <?php
                            if ($guest_id === NULL) {
                                ?>
                                <p><?= $sprint['age_min'] . '-' . $sprint['age_max'] ?></p>
                                <p><img src="images/ico/<?= $sprint['sprint_lang'] ?>.png"></p>
                                <?php
                            }
                            ?>
                            <p>€<?= $sprint['price'] ?></p>


                            <br>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="col-md-5 col-md-offset-1 pay_cc" style="text-align: center">
                            <form action="<?= strtolower($lang['NAME']) ?>/payment.php" method="post">
                                <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
                                <input type="hidden" name="guest_id" value="<?= $guest_id ?>">
                                <input type="hidden" name="participant_id" value="<?= $loggedInUser->user_id ?>">
                                <input type="hidden" name="fee" value="<?= $sprint['price'] ?>">
                                <button style=" margin-padding: 2px;" class="btn btn-default btn-md btn-danger"
                                        type="submit"><i
                                        class="button-icon fa fa-credit-card"></i><?= $lang['PAYMENT_CC'] ?></button>
                            </form>
                        </div>
                        <div class="col-md-5" style="text-align: center">
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                <input type="hidden" name="cmd" value="_xclick">
                                <!--<input type="hidden" name="business" value="sallami.ismail-facilitator@gmail.com">-->
                                <input type="hidden" name="business" value="sallami.ismail@gmail.com">
                                <input type="hidden" name="lc" value="DE">
                                <input type="hidden" name="custom" value="<?= $PaypalData ?>">
                                <input type="hidden" name="item_name" value="Speeddate Booking (ref: <?= $sprint_id ?>-<?= $loggedInUser->user_id ?>)">
                                <input type="hidden" name="button_subtype" value="services">
                                <input type="hidden" name="no_note" value="0">
                                <input type='hidden' name='rm' value='2'>
                                <input type="hidden" name="amount" value="<?= $sprint['price'] ?>">
                                <input type="hidden" name="currency_code" value="EUR">
                                <input type="hidden" name="notify_url" value="https://www.hitchme.de/<?= strtolower($lang['NAME']) ?>/pp_return.php">
                                <input type="hidden" name="return" value="https://www.hitchme.de/<?= strtolower($lang['NAME']) ?>/pp_return.php?result=success" />
                                <input type="hidden" name="cancel_return" value="https://www.hitchme.de/<?= strtolower($lang['NAME']) ?>/pp_return.php?result=cancel">
                                <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
                                <button style=" margin-padding: 2px;" class="btn btn-default btn-md btn-info"
                                        type="submit"><i
                                        class="button-icon fa fa-paypal"></i><?= $lang['PAYMENT_PP'] ?></button>
                            </form><br>
                        </div>
                    </div>
                    <div>
                        <?php
                        if ($guest_id === NULL) {
                        ?>

                        <div class="col-md-12 ">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td><?= date("H:i", strtotime("-10 minutes", strtotime($sprint['time']))) ?></td>
                                    <td><?= $lang['SPRINT_PLAN_1'] ?></td>
                                </tr>
                                <tr>
                                    <td><?= $sprint['time'] ?></td>
                                    <td><?= $lang['SPRINT_PLAN_2'] ?></td>
                                </tr>
                                <tr>
                                    <td><?= date("H:i", strtotime("5 minutes", strtotime($sprint['time']))) ?></td>
                                    <td><?= $lang['SPRINT_PLAN_3'] ?></td>
                                </tr>
                                <tr>
                                    <td><?= date("H:i", strtotime("75 minutes", strtotime($sprint['time']))) ?></td>
                                    <td><?= $lang['SPRINT_PLAN_4'] ?></td>
                                </tr>
                                <tr>
                                    <td><?= $lang['FROM'] ?> <?= date("H:i", strtotime("80 minutes", strtotime($sprint['time']))) ?></td>
                                    <td><?= $lang['SPRINT_PLAN_5'] ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2645.9577697739874!2d13.5163!3d52.49473!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4d5923eaca84fa67%3A0xfd2f9f807114acd4!2s292+Shuniah+St%2C+Thunder+Bay%2C+ON+P7A+3A2!5e0!3m2!1sen!2sca!4v1424272931061" width=100% height="450" frameborder="0" style="border:0"></iframe>-->
                    <!-- Google Maps Code Kopieren -->
                    <iframe width="100%"
                            height="450"
                            src="https://maps.google.de/maps?hl=<?= $lang['NAME'] ?>&q=<?= $sprint['location'] ?>  <?= $sprint['city'] ?>&ie=UTF8&t=&z=17&iwloc=B&output=embed"
                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>

                    <br/>
                <?php
                //End of Error test
                }
                ?>

            </div>
            </div>
        </div>
    </section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>
<script>
    function stripeResponseHandler(status, response) {
        // Grab the form:
        var $form = $('#payment-form');

        if (response.error) { // Problem!

            // Show the errors on the form:
            $form.find('.payment-errors').text(response.error.message);
            $form.find('.submit').prop('disabled', false); // Re-enable submission

        } else { // Token was created!

            // Get the token ID:
            var token = response.id;

            // Insert the token ID into the form so it gets submitted to the server:
            $form.append($('<input type="hidden" name="stripeToken">').val(token));

            // Submit the form:
            $form.get(0).submit();
        }
    };


</script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    Stripe.setPublishableKey('pk_live_HBv3HDcdk7bZvR7tGO63NWWa');
    $(function() {
        var $form = $('#payment-form');
        $form.submit(function(event) {
            // Disable the submit button to prevent repeated clicks:
            $form.find('.submit').prop('disabled', true);

            // Request a token from Stripe:
            Stripe.card.createToken($form, stripeResponseHandler);

            // Prevent the form from being submitted:
            return false;
        });
    });

</script>

</body>
</html>
