<?php
if(isUserLoggedIn()){
    //display unread message notification
    $unread = getUnreadMessage($loggedInUser->user_id);
    if ($unread>0){
        $unreadNotification ="<span class='badge badge-notify'>".$unread."</span>";
    }else{
        $unreadNotification="";
    }

    //display alert for empty profile
    $profile = fetchUserProfile($loggedInUser->user_id);
    if (empty($profile)){
        $profileAlert = "<span class='badge profile-notify'>!</span>";
    }else{
        $profileAlert ="";
    }
}

?>
<header id="header">
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-4">
                </div>
                <div class="col-sm-6 col-xs-8">
                    <div class="social">
                        <ul class="social-share">

                            <li><a href="http://www.facebook.com/hitchme.de"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https://www.youtube.com/channel/UCTjhlLUAFSGCBYIhovOI8LA"><i class="fa fa-youtube"></i></a></li>
                            <a href="en/<?= basename($_SERVER['SCRIPT_NAME']) ?>"><img src="images/ico/EN.png" alt="english flag"></a>
                            <a href="de/<?= basename($_SERVER['SCRIPT_NAME']) ?>"><img src="images/ico/DE.png" alt="german flag"> </a>

                        </ul>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </div><!--/.top-bar-->

    <nav class="navbar navbar-inverse" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= strtolower($lang['NAME']) ?>/index.php"><img src="images/logo.png" alt="logo"></a>
            </div>
            <div class="collapse navbar-collapse navbar-right">
                <ul class="nav navbar-nav">
                    <li><a href="<?= strtolower($lang['NAME']) ?>/index.php">Home</a></li>
                    <li><a href="<?= strtolower($lang['NAME']) ?>/events-list.php">SpeedDating</a></li>
                    <li><a href="<?= strtolower($lang['NAME']) ?>/invite.php"><?= lang('INVITE_ME'); ?></a></li>
                    <?php
                    if(!isUserLoggedIn()) {
                        echo '<li><a href="'. strtolower($lang['NAME']) .'/login.php">' . lang('LOGIN') . '</a></li>';
                    }
                    ?>
                    <li><a href="<?= strtolower($lang['NAME']) ?>/contact-us.php"><?= lang('CONTACT'); ?></a></li>
                </ul>
            </div>
        </div><!--/.container-->
    </nav><!--/nav-->
    <?php
    if(isUserLoggedIn()) {
        ?>
        <nav class="loggedbar navbar-inverse" role="banner">
            <div class="container">
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav loggedbar">
                        <?php
                        //Links for permission level 2 (default admin)
                        if ($loggedInUser->checkPermission(array(2))){

                            echo "
                                 <li class='dropdown'>
                                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Events <i class='fa fa-angle-down'></i></a>
                                    <ul class='dropdown-menu'>
                                        <li><a href='". strtolower($lang['NAME']) ."/new_event.php'>New Event</a></li>
                                        <li><a href='". strtolower($lang['NAME']) ."/new_sprint.php'>New Sprint</a></li>
                                        <li><a href='". strtolower($lang['NAME']) ."/admin_sprints.php'>Display Sprints</a></li>
                                        <li><a href='". strtolower($lang['NAME']) ."/matches.php'>Matches</a></li>

                                    </ul>
                                    </li>
                                    <li><a href='". strtolower($lang['NAME']) ."/admin_configuration.php'>Admin Configuration</a></li>
                                    <li><a href='". strtolower($lang['NAME']) ."/admin_users.php'>Admin Users</a></li>
                                    <li><a href='". strtolower($lang['NAME']) ."/admin_permissions.php'>Admin Permissions</a></li>
                                    <li><a href='". strtolower($lang['NAME']) ."/admin_pages.php'>Admin Pages</a></li>
                                ";
                        }elseif ($loggedInUser->checkPermission(array(3))) {
                            echo "
                                 <li class='dropdown'>
                                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Events <i class='fa fa-angle-down'></i></a>
                                    <ul class='dropdown-menu'>
                                        <li><a href='". strtolower($lang['NAME']) ."/new_event.php'>New Event</a></li>
                                        <li><a href='". strtolower($lang['NAME']) ."/new_sprint.php'>New Sprint</a></li>
                                        <li><a href='". strtolower($lang['NAME']) ."/admin_sprints.php'>Display Sprints</a></li>
                                        <li><a href='". strtolower($lang['NAME']) ."/matches.php'>Matches</a></li>

                                    </ul>
                                    </li>
                                ";
                        }else{
                            echo "
                                <li><a href='". strtolower($lang['NAME']) ."/ratings.php'>". lang('RATINGS') ."</a></li>
                                <li><a href='". strtolower($lang['NAME']) ."/matches.php'>". lang('MATCHES') ."</a></li>
                                <li><a href='". strtolower($lang['NAME']) ."/messages.php'>". lang('MESSAGE') . $unreadNotification."</a></li>
                                <li><a href='". strtolower($lang['NAME']) ."/user_settings.php'>". lang('SETTINGS') ." </a></li>
                                <li><a href='". strtolower($lang['NAME']) ."/edit_profile.php'>". lang('EDIT') . $profileAlert."</a></li>

                              ";

                        }
                        ?>
                        <li><a href="<?= strtolower($lang['NAME']) ?>/logout.php"><?= lang('LOGOUT') ?></a></li>
                        <li><a href='<?= strtolower($lang['NAME']) ?>/account.php'><span class='fa fa-user'></span> <?= lang('WELCOME') ?> <?= $loggedInUser->username ?></a></li>
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->

        <?php
    }
    ?>

</header><!--/header-->