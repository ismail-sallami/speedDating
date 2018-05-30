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
            <div class="row">
                <?php
                $sprint =fetchSprint($_POST['sprint_id']);

                try {
                    require_once('../Stripe/init.php');
                    \Stripe\Stripe::setApiKey("sk_live_ySsPIGR9iicLRW9nffUoNTUb"); //Secret Key

                    $token = $_POST['stripeToken'];
                    if ($_POST['couponId']){
                        $coupon = \Stripe\Coupon::retrieve($_POST['couponId']);
                        $customer = \Stripe\Customer::create(array(
                            'email' => $loggedInUser->email,
                            'source'  => $token,
                            'coupon' => $coupon
                        ));
                        $discount = $coupon->percent_off;
                    }else{
                        $customer = \Stripe\Customer::create(array(
                            'email' => $loggedInUser->email,
                            'source'  => $token,
                        ));
                        $discount = 0;
                    }

                    $charge =  \Stripe\Charge::create(array(
                        "amount" => $sprint['price'] * 100 * (1-$discount/100),
                        "currency" => "eur",
                        //"card" => $token,
                        'customer' => $customer->id,
                        "description" => $loggedInUser->user_id .': '. strftime("%a, %e %b %Y", date_create($sprint['date'])->getTimestamp()) . ' at: ' . $sprint['time'],
                    ));
                    //send the file, this line will be reached if no error was thrown above
                    echo "<div class='alert alert-success'>" . $lang['PAYMENT_SUCCESS'] ."</div>";
                    $user_id = $_POST['user_id'];
                    $sprint_id = $_POST['sprint_id'];
                    $guest_id = $_POST['guest_id'];

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
                    //catch the errors in any way you like
                catch(Stripe_CardError $e) {
                }
                catch (Stripe_InvalidRequestError $e) {
                    // Invalid parameters were supplied to Stripe's API
                } catch (Stripe_AuthenticationError $e) {
                    // Authentication with Stripe's API failed
                    // (maybe you changed API keys recently)
                } catch (Stripe_ApiConnectionError $e) {
                    // Network communication with Stripe failed
                } catch (Stripe_Error $e) {
                    // Display a very generic error to the user, and maybe send
                    // yourself an email
                } catch (Exception $e) {
                    echo "<div class='alert alert-danger'>" . $e->getMessage() ."</div>";
                }
                ?>
            </div>
        </div>
        </div>
    </section><!--/#portfolio-item-->
<?php
require_once 'footer.php';
?>
</body>
</html>
