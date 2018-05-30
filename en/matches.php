<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once ('head.php');

?>

</head>
<body>

<?php
require_once 'header.php';
$matches = getMatchesList($loggedInUser->user_id);
?>
    <section id="portfolio">
        <div class="container">
            <div class="col-sm-4 col-md-offset-4 wow ">
                <?php
                if (!$matches){
                echo '<div class="alert alert-warning">'.lang('NO_MATCHES_YET').'</div>';
                }else {
                    ?>

                    <div class="testimonial">
                        <h2><?= lang('MATCHES') ?></h2>
                        <?php
                        foreach ($matches as $match) {
                            $match_profile = fetchUserProfile($match['match_id']);
                            echo '<br>
                            <div class="media testimonial-inner">
                                <div class="pull-left">
                                    <img class="img-responsive img-circle" height="150" width="100" src="images/profiles/' . $match['match_id'] . '/' . $match_profile['profile_pic'] . '">
                                </div>
                                <div class="media-body">
                                    <span><strong><a href="'. strtolower($lang['NAME']).'/profile.php?id=' . $match['match_id'] . '">' . $match_profile['fname'] . ' ' .  substr($match_profile['lname'],0,1) . '.</a></strong> </span>
                                    <p><i class="fa fa-phone-square"></i> ' . $match_profile['phone'] . '<br>
                                   <i class="fa fa-envelope"></i> ' . $match_profile['phone'] . '</p>


                                </div>
                            </div>
                            ';

                        }
                        ?>

                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>


</body>
</html>
