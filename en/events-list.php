<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//Get the list of Events and Sprints
$events = array_unique(fetchAllSprints(true)[0], SORT_REGULAR);
$sprints = fetchAllSprints(true)[1];
require_once 'head.php';
echo '
<title>HitchMe &hearts; Choose your event and join us</title>
<meta name="keywords" content="SpeedDating, speed dating events, singles in Berlin" />
<meta name="description" content="Browse and select your dating event and join us to meet your soulmate.">

</head><body>';
include_once("../models/analyticstracking.php");
require_once 'header.php';
?>
    <section id="backgroundedDiv" class="transparent-bg">
        <div id="innerBackgroundedDiv" class="container">
            <h1>Events list</h1>
            <p>Select your event and join us to meet singles and find your soulmate</p>
            <?php
                if ($sprints) {
                    ?>
                    <div class="row">
                        <?php
                        foreach ($events as $event) {
                            ?>
                            <div class="features WOW">
                                <div class="feature-calendar">
                                    <i class="fa fa-calendar"></i>
                                    <h2><?= strftime("%A, %e %B %Y", date_create($event['date'])->getTimestamp()) ?></h2>
                                </div>

                                <div class="feature-location">
                                    <i class="fa fa-map-marker"></i>
                                    <h2><?= $event['location'] ?></h2>
                                </div>
                                <table class="table table-sm ">
                                    <thead>
                                    <tr class="table-active">
                                        <th><?= $lang['TIME'] ?></th>
                                        <th><?= $lang['LANGUAGE'] ?></th>
                                        <th><?= $lang['AGE'] ?></th>
                                        <th><?= $lang['AVAILABLE'] ?></th>
                                        <th><?= $lang['BOOK'] ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($sprints as $sprint) {
                                        if ($event['event_id'] == $sprint['event_id']) {
                                            //Icon availability color
                                            if ($sprint['w_booked'] / $sprint['w_available'] >= 1) {
                                                $w_ico_css = 'available-full';
                                            } elseif ($sprint['w_booked'] / $sprint['w_available'] > 0.2) {
                                                $w_ico_css = 'available-low';
                                            } else {
                                                $w_ico_css = 'available-high';
                                            }

                                            if ($sprint['m_booked'] / $sprint['m_available'] >= 1) {
                                                $m_ico_css = 'available-full';
                                            } elseif ($sprint['m_booked'] / $sprint['m_available'] > 0.2) {
                                                $m_ico_css = 'available-low';
                                            } else {
                                                $m_ico_css = 'available-high';
                                            }
                                            echo '<tr>
                                        <th scope="row">' . $sprint['time'] . '</th>
                                        <td><img src="images/ico/' . $sprint['sprint_lang'] . '.png"></td>
                                        <td>' . $sprint['age_min'] . '-' . $sprint['age_max'] . '</td>
                                        <td><i class="' . $w_ico_css . ' fa fa-female"></i><i class="' . $m_ico_css . ' fa fa-male"></i></td>
                                        <td class="col-md-2">
                                                <a href="'.strtolower($lang['NAME']).'/speeddate-booking.php?sprint=' . $sprint['sprint_id'] . '" style=" margin-padding: 2px;" class="btn btn-default btn-xs btn-danger"><i class="button-icon fa fa-credit-card"></i> €' . $sprint['price'] . '</a>
                                        </td>
                                    </tr>';
                                        }

                                    }
                                    ?>


                                    </tbody>
                                </table>
                            </div><!--/.services-->

                            <?php
                        }
                        ?>


                    </div><!--/.row-->

                    <?php
                }else{
                    echo ' <div class="clients-area center wow fadeInDown">
                <h2>Sorry, no events are available currently</h2>
            </div>';
                }
            ?>


            <div class="get-started wow fadeInDown">
                <div class="center">
                    <h2><?= $lang['READY_TO_START_TITLE'] ?></h2>
                </div>
                <div class="container">
                    <?= $lang['READY_TO_START_TEXT'] ?>
                </div>
            </div><!--/.get-started-->

        </div><!--/.container-->
    </section><!--/#feature-->


<?php
require_once 'footer.php';
?>
</body>
</html>