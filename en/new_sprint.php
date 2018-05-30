<!DOCTYPE html>
<html lang="en">
<head>
<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Forms posted
if(!empty($_POST))
{
    $event_id = $_POST['event_id'];
    $time = $_POST['time'];
    $sprint_lang = $_POST['sprint_lang'];
    $w_places = $_POST['w_places'];
    $m_places = $_POST['m_places'];
    $price = $_POST['price'];
    $age_from = $_POST['age_from'];
    $age_to = $_POST['age_to'];

    if (AddSprint($event_id, $time, $sprint_lang, $w_places, $m_places, $price, $age_from, $age_to )){
        $successes[] = lang("NEW_SPRINT_ADDED");
    }
    else {
        $errors[] = lang("SQL_ERROR");
    }

}
require_once ('head.php');
echo "
</head><body>";
require_once 'header.php';

echo "
    <section id=\"portfolio\">
        <div class=\"container\">
			";
?>
     <div id='regbox'  class="col-sm-6 col-md-offset-3">
            <?= resultBlock($errors,$successes); ?>
            <h2>New Sprint</h2>
            <form name='login' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
                <label>Select event:</label>

                <?php
                $sql = "SELECT * FROM dating_event WHERE date>=CURDATE() ORDER BY date";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    echo "<select class='form-control' name='event_id'>";
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["id"] . "'>" . $row["date"]." - ". $row["location"] ."</option>";
                    }
                    echo "</select>";
                } else {
                    echo "0 results";
                }
                $mysqli->close();
                ?>

                <label>Time:</label>
                <input type='time' class="form-control" name='time' required />
                <label>Language:</label>
                <Select name="sprint_lang" class="form-control" >
                    <option>DE</option>
                    <option>EN</option>
                </Select>
                <label>Woman places:</label>
                <input type='number' class="form-control" name='w_places' min="1" value="10" required />
                <label>Men places:</label>
                <input type='number' class="form-control" name='m_places' min="1" value="10" required />
                <label>Price:</label>
                <input type='number' class="form-control" name='price' min="1" required />
                <label>Age:</label><br>
                <div class="input-group">
                    <input type="number" class="form-control" name='age_from'/>
                    <span class="input-group-addon">-</span>
                    <input type="number" class="form-control" name='age_to'/>
                </div>
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
