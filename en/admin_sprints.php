<!DOCTYPE html>
<html lang="en">
<head>
<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Forms posted
if(!empty($_POST))
{
	//Check admin privileges
	if (!$loggedInUser->checkPermission(array(2))){
		$errors[] = "Sorry! You are not allowed to perform this action, please contact the administrator";
	}else{

		$deletions = $_POST['delete'];
		if ($deletion_count = deleteSprints($deletions)){
			$successes[] = lang("SPRINT_DELETIONS_SUCCESSFUL", array($deletion_count));
		}else {
			$errors[] = lang("SQL_ERROR");
		}
	}
}

$sprintsData = fetchAllSprints(false)[2]; //Fetch information for all users
require_once ('head.php');

echo "</head><body>";
require_once 'header.php';
?>
	<section id="portfolio">
		<div class="container">

		<?php
		echo resultBlock($errors,$successes);

		echo "
		<form action='".$_SERVER['PHP_SELF']."' method='post'>
		<table id='example' class='table-hover -bordered table-striped' cellspacing='0' width='100%'>
		 <thead><tr>
		<th>Del.</th><th>ID</th><th>Date</th><th>Time</th><th>Location</th><th>Age</th><th>Lang.</th><th>Women</th><th>Men</th>
		</tr> </thead> <tbody>";

		//Cycle through users
		foreach ($sprintsData as $sprint) {
			echo "
			<tr>
			<td><input type='checkbox' name='delete[".$sprint['sprint_id']."]' id='delete[".$sprint['sprint_id']."]' value='".$sprint['sprint_id']."'></td>
			<td><a href='".strtolower($lang['NAME'])."/admin_sprint.php?id=".$sprint['sprint_id']."'>".$sprint['sprint_id']."</a></td>
			<td>".$sprint['date']."</td>
			<td>".$sprint['time']."	</td>
			<td>".$sprint['location']."	</td>
			<td>".$sprint['age_min']."-".$sprint['age_max']."</td>
			<td><img src='images/ico/".$sprint['sprint_lang'].".png'> </td>
			<td>".$sprint['w_booked']."	</td>
			<td>".$sprint['m_booked']."	</td>
			</tr>";
		}

		echo "
		 </tbody></table>
		<input type='submit' class=\"btn btn-primary btn-lg\" name='Submit' value='Delete' />
		</form>

        </div>
    </section><!--/#portfolio-item-->
";
require_once 'footer.php';
?>


			<script src="js/jquery.js"></script>
			<script src="js/dataTables.js"></script>

			<script type="text/javascript">
				$(document).ready(function() {
					$('#example').DataTable({
						"scrollY":        "500px",
						"scrollCollapse": true,
						"paging":         false
					} );
				} );
			</script>
			</body>
</html>

