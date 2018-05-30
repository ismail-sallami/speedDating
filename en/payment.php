<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//get sprint details
//if no sprint (direct access), foreword to error page
try {
    $sprint_id = $_POST['sprint_id'];
    $sprint =fetchSprint($sprint_id);
    if(!$sprint){
        header('Location: error.php'); die();
    }
}

//catch exception
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}
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
                <!-- You can make it whatever width you want. I'm making it full width
                     on <= small devices and 4/12 page width on >= medium devices -->
                <div class="col-xs-12 col-md-4 col-md-offset-4">


                    <!-- CREDIT CARD FORM STARTS HERE -->
                    <div class="panel panel-default credit-card-box">
                        <div class="panel-heading display-table" >
                            <div class="row display-tr" >
                                <h3 class="panel-title display-td" ><?= $lang['DETAIL'] ?></h3>
                                <div class="display-td" >
                                    <img class="img-responsive pull-right" src="images/accepted_cards.png">
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <!--<form role="form" id="payment-form" method="POST" action="charge.php" >
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="cardNumber">CARD NUMBER</label>
                                            <div class="input-group">
                                                <input
                                                    type="tel"
                                                    class="form-control"
                                                    name="cardNumber"
                                                    size="20"
                                                    data-stripe="number"
                                                    placeholder="Valid Card Number"
                                                    autocomplete="cc-number"
                                                    required autofocus
                                                />
                                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-7 col-md-7">
                                        <div class="form-group">
                                            <label for="cardExpiry"><span class="visible-xs-inline">EXP</span> DATE</label>
                                            <input
                                                type="tel"
                                                class="form-control"
                                                name="cardExpiry"
                                                placeholder="MM / YY"
                                                autocomplete="cc-exp"
                                                required
                                            />
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-md-5 pull-right">
                                        <div class="form-group">
                                            <label for="cardCVC">CV CODE</label>
                                            <input
                                                type="tel"
                                                class="form-control"
                                                name="cardCVC"
                                                placeholder="CVC"
                                                autocomplete="cc-csc"
                                                data-stripe="cvc"
                                                required
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="couponCode">COUPON CODE</label>
                                            <input type="text" class="form-control" name="couponCode" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="submit" class="subscribe btn btn-success btn-lg btn-block" value="Submit Payment"

                                    </div>
                                </div>
                                <div class="row" style="display:none;">
                                    <div class="col-xs-12">
                                        <p class="payment-errors"></p>
                                    </div>
                                </div>
                            </form>-->

                            <form action="<?= strtolower($lang['NAME']) ?>/charge.php" method="POST" id="payment-form" autocomplete="off">
                                <span class="payment-errors" style="color: red;"></span>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="cardNumber"><?= $lang['NUMBER'] ?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="cardNumber" placeholder="<?= $lang['VALID_NUMBER'] ?>"  axlength="20" required autofocus data-stripe="number" />
                                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-7 col-md-7">
                                        <div class="form-group">
                                            <label for="expMonth"><?= $lang['EXPIRATION'] ?></label>
                                            <div class="col-xs-6 pull-left " style="padding-left: 0px">
                                                <input type="text" class="form-control" name="expMonth" placeholder="MM" maxlength="2" size="2"  required data-stripe="exp_month" />
                                            </div>
                                            <div class="col-xs-6 col-lg-6 " style="padding-left: 0px">
                                                <input type="text" class="form-control" name="expYear" placeholder="<?= $lang['YY'] ?>" size="2" maxlength="2"  required data-stripe="exp_year" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-md-5 pull-right">
                                        <div class="form-group">
                                            <label for="cvCode">CV CODE</label>
                                            <input type="password" class="form-control" name="cvCode" placeholder="CV"  maxlength="4" required data-stripe="cvc" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="couponCode"><?= $lang['COUPON'] ?></label>
                                            <input type="text" class="form-control" name="couponId" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
                                        <input type="hidden" name="user_id" value="<?= $loggedInUser->user_id ?>">
                                        <input type="hidden" name="guest_id" value="<?= $_POST['guest_id'] ?>">
                                        <button class="btn btn-success btn-lg btn-block" type="submit"><img src="images/payment/loader.gif" id="loadingGif" style="display:none"/ ><?= $lang['SUBMIT_PAYMENT'] ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <img src="images/stripe.png" height="20" style="margin-top: -40px">
                    <!-- CREDIT CARD FORM ENDS HERE -->
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
        var errorMessages = {
            incorrect_number: "<?= $lang['incorrect_number'] ?>",
            invalid_number: "<?= $lang['invalid_number'] ?>",
            invalid_expiry_month: "<?= $lang['invalid_expiry_month'] ?>",
            invalid_expiry_year: "<?= $lang['invalid_expiry_year'] ?>",
            invalid_cvc: "<?= $lang['invalid_cvc'] ?>",
            expired_card: "<?= $lang['expired_card'] ?>",
            incorrect_cvc: "<?= $lang['incorrect_cvc'] ?>",
            incorrect_zip: "<?= $lang['incorrect_zip'] ?>",
            card_declined: "<?= $lang['card_declined'] ?>",
            missing: "<?= $lang['missing'] ?>",
            processing_error: "<?= $lang['processing_error'] ?>",
            rate_limit:  "<?= $lang['rate_limit'] ?>"
        };


        if (response.error) { // Problem!

            // Show the errors on the form:
            $form.find('.payment-errors').text(errorMessages[ response.error.code ] );
            $form.find('.submit').prop('disabled', false); // Re-enable submission
            $("#loadingGif").hide();


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

<script type="text/javascript" src="https://js.stripe.com/v2/"
        data-locale="DE">
</script>
<script type="text/javascript">
    Stripe.setPublishableKey('pk_live_HBv3HDcdk7bZvR7tGO63NWWa');
    Stripe
    $(function() {
        var $form = $('#payment-form');
        $form.submit(function(event) {
            // Disable the submit button to prevent repeated clicks:
            $form.find('.submit').prop('disabled', true);
            $("#loadingGif").show();

            // Request a token from Stripe:
            Stripe.card.createToken($form, stripeResponseHandler);

            // Prevent the form from being submitted:
            return false;
        });
    });
</script>

</body>
</html>
