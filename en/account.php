<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

if (isset($_SESSION['referer'])){
    $to_perform = $_SESSION['referer'];
    unset($_SESSION['referer']);
    header('Location:'.$to_perform);
    die();
}
//Forms posted
if(!empty($_POST)) {
$bookingCanceled = cancelSprint($_POST['user_id'], $_POST['sprint_id']);
    if($bookingCanceled){
        $successes[] = lang("SPRINT_CANCELLED");
    }else{
        $errors[] = lang("SQL_ERROR");
    }
}

$mysprints = fetchUserSprints($loggedInUser->user_id);

require_once ('head.php');
echo "
</head><body>";
require_once 'header.php';
?>
<section id="portfolio">
    <div class="container">
        <div class="col-sm-8 col-md-offset-2 wow ">
            <?php
            echo resultBlock($errors,$successes);
            if (empty($mysprints)){
                echo '<div class="alert alert-warning">' . lang('NO_UPCOMING_EVENT'). '</div>';
            }else{
                echo "<h2>" .lang('UPCOMING_EVENT') ."</h2>";
                foreach($mysprints as $sprint){
                    if($sprint['sprint_date'] > date('Y-m-d')){
                        echo '<form method="POST">
                        <input type="hidden" name="user_id" value="'.$loggedInUser->user_id.'">
                        <input type="hidden" name="sprint_id" value="'.$sprint['sprint_id'].'">
                        <div class="well well-sm"><i class="fa fa-calendar"></i> '.$sprint['sprint_date'].
                            ' <i class="fa fa-clock-o"></i> '.$sprint['sprint_time'].
                            ' <i class="fa fa-map-marker"></i> '.fetchSprint($sprint['sprint_id'])['location'].
                            '<button type="submit" class="pull-right btn btn-default btn-xs btn-danger"><i class="fa fa-times-circle"></i> '. lang('CANCEL') .'</button>
                        </div></form>';
                    }else{
                        echo '
                        <div class="well well-sm expired"><i class="fa fa-calendar"></i> '.$sprint['sprint_date'].
                            ' <i class="fa fa-clock-o"></i> '.$sprint['sprint_time'].
                            ' <i class="fa fa-map-marker"></i> '.fetchSprint($sprint['sprint_id'])['location'].
                            '</div>
                        ';
                    }
                }
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


