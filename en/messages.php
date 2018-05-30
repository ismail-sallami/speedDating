<!DOCTYPE html>
<html lang="en">
<head>
<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$user_id = $loggedInUser->user_id;

//Forms posted
if(!empty($_POST))
{
	$msg_to_delete = $_POST['delete'];
	if ($deletion_count = deleteMessages($msg_to_delete)){
		$successes[] = lang("MESSAGES_DELETIONS_SUCCESSFUL", array($deletion_count));
	}
	else {
		$errors[] = lang("NO_SELECTED_MESSAGES");
	}
}
$userMessages = fetchUserMessages($user_id); //Fetch message, 'all' for all users
require_once ('head.php');

echo "
</head><body>";
require_once 'header.php';
?>
	<section id="portfolio">
		<div class="container">
		<?php
		echo resultBlock($errors,$successes);

		echo "
		<form name='adminUsers' action='".$_SERVER['PHP_SELF']."' method='post'>
		<table id='example' class='table table-inbox table-hover' cellspacing='0' width='100%'>
		 <thead><tr>
		<th>".lang('DELETE')."</th><th>".lang('TITLE')."</th><th>".lang('TIME')."</th></tr> </thead> <tbody>";

		//Cycle through users
		foreach ($userMessages as $message) {
			if (!$message['read'])
			{$read =" style='background-color:#FBEFEF;font-weight:bold;'";}
			else{
				$read=" style='background-color:white;'";
			}
			echo "
			<tr ".$read.">
			<td><input type='checkbox' name='delete[".$message['id']."]' id='delete[".$message['id']."]' value='".$message['id']."'></td>
			<td><a href='". strtolower($lang['NAME'])."/view_message.php?id=".$message['id']."'>".$message['title']."</a></td>
			<td>".$message['timestamp']."</td>
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
			<script>
				var search_label = "<?= lang('SEARCH_LABEL') ?>";
				var showing = "<?= lang('SHOWING') ?>";
				var showing_0 = "<?= lang('SHOWING_0') ?>";
				var no_available_data = "<?= lang('NO_DATA') ?>";
			</script>

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

