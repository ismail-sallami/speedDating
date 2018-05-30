<!DOCTYPE html>
<html lang="en">
<head>
<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Forms posted
if(!empty($_POST))
{
    $date = $_POST['date'];
    $location = $_POST['location'];
    $city = $_POST['city'];
    if (AddEvent($date, $location, $city)){
        $successes[] = lang("NEW_EVENT_ADDED");
    }
    else {
        $errors[] = lang("SQL_ERROR");
    }
}
require_once ('head.php');
echo "
</head>
<body>";
require_once 'header.php';

echo "
    <section id=\"portfolio\">
        <div class=\"container\">
			";

echo resultBlock($errors,$successes);
?>
        <div id='regbox'  class="col-sm-6 col-md-offset-3">
            <h2>New event</h2>
            <form name='login' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
                <label>Date:</label>
                <input type='date' class="form-control" name='date' required/>
                <label>Location:</label>
                <input type='text' class="form-control" name='location' required />
                <label>City:</label>
                <input type='text' class="form-control" name='city' required />
                <input type='submit'  class="btn btn-primary btn-lg" value='Submit' class='submit' />
            </form>
        </div>

        </div>
    </section><!--/#portfolio-item-->
<?php
require_once 'footer.php';
?>
</body>
</html>