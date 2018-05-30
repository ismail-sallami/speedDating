<?php
require_once("../models/config.php");
//if(basename($_SERVER['HTTP_REFERER']=="login.php")){
if(isUserLoggedIn()) {
    unset($_SESSION["referer"]);
}else{
    $_SESSION["referer"] = $_SERVER['REQUEST_URI'];
}

if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once ('head.php');
?>
</head>
<body>
<?php
require_once 'header.php';
//get the user profile
if (isset($_GET['id'])){
    $user_id = $_GET['id'];
}else{
    $user_id = $loggedInUser->user_id;
}
define('IMAGEPATH', '../images/profiles/'.$user_id.'/');
$userProfile = fetchUserProfile($user_id);
$fullSprints = fetchAllSprints(true)[2];

?>
    <section id="portfolio">
        <div class="container">
            <div class="media">
                <?php
                if (empty($userProfile)){
                    echo '<div class="alert alert-warning"> ' . lang('EMPTY_PROFILE') . ' </div>';
                }else {
                    echo resultBlock($errors, $successes);
                    ?>
                    <div class="col-md-4">

                        <section id="profile-slider" class="no-margin">
                            <div class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php
                                    /*$pic_count = count(glob(IMAGEPATH . '*'));

                                    for ($i = 0; $i < $pic_count; $i++) {
                                        $active = '';
                                        if ($i == 0)
                                            $active = ' class="active"';
                                        echo '<li data-target="#profile-slider" data-slide-to="' . $i . '" ' . $active . '></li>';
                                    }*/

                                    $count=0;
                                    foreach (glob(IMAGEPATH . '*') as $filename) {
                                        if (basename($filename) == $userProfile['profile_pic']){
                                            $active = ' class="active"';
                                        }else{
                                            $active = '';
                                        }

                                        echo '<li data-target="#profile-slider" data-slide-to="' . $count . '" ' . $active . '></li>';
                                        $count++;
                                    }
                                    ?>
                                </ol>
                                <div class="carousel-inner ">
                                    <?php
                                    foreach (glob(IMAGEPATH . '*') as $filename) {
                                        if (basename($filename) == $userProfile['profile_pic']){
                                            $active = ' active';
                                        }else{
                                            $active = '';
                                        }

                                        echo '
                                            <div class="item' . $active . '">
                                                <img src="images/profiles/' . $user_id . '/' . basename($filename) . '">
                                            </div><!--/.item-->
                                     ';
                                    }
                                    ?>
                                </div><!--/.carousel-inner-->
                            </div><!--/.carousel-->

                            <a class="prev hidden-xs" href="#profile-slider" data-slide="prev">
                                <i class="fa fa-chevron-left"></i>
                            </a>
                            <a class="next hidden-xs" href="#profile-slider" data-slide="next">
                                <i class="fa fa-chevron-right"></i>
                            </a>
                        </section><!--/#main-slider-->
                        <br>
                        <?php
                        if ($user_id != $loggedInUser->user_id) {


                            ?>
                            <form method="POST" action= "<?= strtolower($lang['NAME']) ?>/booking.php">
                                <input name="inviting" type="hidden" value="<?= $loggedInUser->user_id ?>">
                                <input name="guest" type="hidden" value="<?= $user_id ?>">
                                <select name="sprint" class="form-control" onchange="this.form.submit()">
                                    <option value="sprint"><?= lang('INVITE_ME'); ?></option>
                                    <?php
                                    foreach ($fullSprints as $sprintOption) {
                                        echo '<option value="' . $sprintOption['sprint_id'] . '">' . $sprintOption['date'] . ' @ ' . $sprintOption['time'] . '  ' . $sprintOption['location'] . ' - ' . $sprintOption['sprint_lang'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="media-body">
                        <div class="col-xs-5 col-md-2">
                            <p><strong><?= lang('FULL_NAME'); ?>: </strong></p>
                            <?php
                            //Show birthdate and phone number for Admin group
                            if ($loggedInUser->checkPermission(array(2))) {
                                echo " <p><strong>".  lang('BIRTH') .": </strong></p>
                                        <p><strong>".  lang('PHONE') .": </strong></p>";
                            } else {
                                echo "<p><strong>".  lang('AGE') .": </strong></p>";
                            }
                            ?>
                            <p><strong><?= lang('GENDER'); ?>: </strong></p>
                            <p><strong><?= lang('MARITAL'); ?>: </strong></p>
                            <p><strong><?= lang('KIDS'); ?>: </strong></p>

                        </div>
                        <div>
                            <p><?= $userProfile['fname'] . ' ' . substr($userProfile['lname'], 0, 1) ?>.</p>
                            <?php
                            if ($loggedInUser->checkPermission(array(2))) {
                                echo "<p>" . $userProfile['bdate'] . "</p>";
                                echo " <p>" . $userProfile['phone'] . "</p>";
                            } else {
                                echo "<p>" . date_diff(date_create($userProfile['bdate']), date_create('now'))->y . "</p>";
                            }
                            ?>
                            <p><?= $userProfile['gender'] ?></p>
                            <p> <?= $userProfile['marital'] ?></p>
                            <p><?= $userProfile['kids'] ?></p>
                        </div>


                        <hr>
                        <div class="col-xs-5 col-md-2">
                            <p><strong><?= lang('EYES'); ?>: </strong></p>
                            <p><strong><?= lang('HAIR'); ?>: </strong></p>
                            <p><strong><?= lang('HEIGHT'); ?>: </strong></p>
                        </div>
                        <div>
                            <p><?= $userProfile['eyes'] ?></p>
                            <p><?= $userProfile['hair'] ?></p>
                            <p><?= $userProfile['height'] ?></p>
                        </div>
                        <hr>
                        <div class="col-xs-5 col-md-2">
                            <p><strong><?= lang('SMOKING'); ?>: </strong></p>
                            <p><strong><?= lang('DRINKING'); ?>: </strong></p>
                            <p><strong><?= lang('HOBBIES'); ?>: </strong></p>
                            <p><strong><?= lang('BOOKS'); ?>: </strong></p>
                            <p><strong><?= lang('MOVIES'); ?>: </strong></p>
                            <p><strong><?= lang('MORE_ABOUT_ME'); ?>: </strong></p>
                        </div>
                        <div>
                            <p><?= $userProfile['smoking'] ?></p>
                            <p><?= $userProfile['drinking'] ?></p>
                            <p><?= $userProfile['hobbies'] ?></p>
                            <p><?= $userProfile['books'] ?></p>
                            <p><?= $userProfile['movies'] ?></p>
                            <p><?= $userProfile['aboutme'] ?></p>
                        </div>
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