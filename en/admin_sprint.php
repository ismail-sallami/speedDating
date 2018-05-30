<!DOCTYPE html>
<html lang="en">
<head>
<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}


//get sprint details
//if no sprint (direct access), foreword to error page
try {
	$sprint =fetchSprint($_GET['id']);
	if(!$sprint){
		header('Location: error.php'); die();
	}
}
//catch exception
catch(Exception $e) {
	echo 'Message: ' .$e->getMessage();
}

//Forms posted
if(!empty($_POST))
{
	$deletions = $_POST['delete'];
	if ($deletion_count = deleteSprints($deletions)){
		$successes[] = lang("SPRINT_DELETIONS_SUCCESSFUL", array($deletion_count));
	}
	else {
		$errors[] = lang("SQL_ERROR");
	}
}
require_once ('head.php');

echo "</head><body>";
require_once 'header.php';
?>
	<section >
		<div  id="section-to-print" class="container">
			<div class="col-md-2 col-xs-4">
				<p><strong>Date: </strong></p>
				<p><strong>Time: </strong></p>
				<p><strong>Location: </strong></p>
				<p><strong>Age: </strong></p>
				<p><strong>Language: </strong></p>
				<p><strong>Price: </strong></p>

			</div>
			<div >
				<p><?= strftime("%A, %e %B %Y", date_create($sprint['date'])->getTimestamp()) ?></p>
				<p><?= $sprint['time'] ?></p>
				<p><?= $sprint['location'] ?></p>
				<p><?= $sprint['age_min'] .'-'.$sprint['age_max'] ?></p>
				<p><img src="images/ico/<?= $sprint['sprint_lang'] ?>.png"></p>
				<p>€<?= $sprint['price'] ?></p>
			</div>

				<?php
		echo resultBlock($errors,$successes);
		//get sprint participants details

		$participantsRow =fetchSprintParticipants($_GET['id']);
		if(empty($participantsRow)){
			echo '<div class="alert alert-warning">No participants.</div>';
		}else
		{
			echo "
		<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>
		<table style='table-layout: fixed;' id='example' class='display' cellspacing='0' width='100%'>
		 <thead><tr>
		<th class='no_print'>Delete</th><th class='no_print'>Account</th><th>Name</th><th>Last name</th><th>Birthdate</th><th>Phone</th><th>Gender</th><th>Hair</th><th>Height</th><th>Marital</th><th>Kids</th>
		</tr> </thead> <tbody>";
			//Cycle through users
			foreach ($participantsRow as $participant) {
				echo "
			<tr>
			<td  class='no_print'><input type='checkbox' name='delete[" . $participant['user_id'] . "]' id='delete[" . $participant['user_id'] . "]' value='" . $participant['user_id'] . "'></td>
			<td  class='no_print'><a href='".strtolower($lang['NAME'])."/admin_user.php?id=" . $participant['user_id'] . "'><i class='icon icon-profile'></i></a></td>
			<td>" . $participant['fname'] . "</td>
			<td>" . $participant['lname'] . "	</td>
			<td>" . $participant['bdate'] . "	</td>
			<td>" . $participant['phone'] . "	</td>
			<td><img src='images/ico/" . $participant['gender'] . ".ico'></td>
			<td>" . $participant['hair'] . "	</td>
			<td>" . $participant['height'] . "	</td>
			<td>" . $participant['marital'] . "	</td>
			<td>" . $participant['kids'] . "	</td>
			</tr>";
			}

			echo "
		 </tbody></table>
		<input type='submit' class=\"btn btn-primary btn-lg no_print\" name='Submit' value='Delete' />
		</form>";
		}


		echo "
        </div>
    </section><!--/#portfolio-item-->";

require_once 'footer.php';
?>


			<script src="js/jquery.js"></script>
			<script src="js/dataTables.js"></script>

			</body>
</html>

