<!DOCTYPE html>
<html lang="en">
<head>
<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Forms posted
if(!empty($_POST))
{
	$deletions = $_POST['delete'];
	if ($deletion_count = deleteUsers($deletions)){
		$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
	}
	else {
		$errors[] = lang("SQL_ERROR");
	}
}

$userData = fetchAllUsers(); //Fetch information for all users
require_once ('head.php');

echo "</head><body>";
require_once 'header.php';
?>
	<section id="portfolio">
		<div class="container">

		<?php
		echo resultBlock($errors,$successes);

		echo "
		<form name='adminUsers' action='".$_SERVER['PHP_SELF']."' method='post'>
		<table id='example' class='table-hover -bordered table-striped' cellspacing='0' width='100%'>
		 <thead><tr>
		<th>Delete</th><th>Username</th><th>Profile</th><th>Inbox</th><th>Last Sign In</th>
		</tr> </thead> <tbody>";

		//Cycle through users
		foreach ($userData as $v1) {
			echo "
			<tr>
			<td><input type='checkbox' name='delete[".$v1['id']."]' id='delete[".$v1['id']."]' value='".$v1['id']."'></td>
			<td><a href='".strtolower($lang['NAME'])."/admin_user.php?id=".$v1['id']."'>".$v1['user_name']."</a></td>
			<td><a href='".strtolower($lang['NAME'])."/view-profile.php?id=" . $v1['id'] . "'><i class='icon icon-profile'></i></a></td>
			<td><a href='".strtolower($lang['NAME'])."/admin_users_inbox.php?id=" . $v1['id'] . "'><i class='fa fa-envelope'></i></a></td>
			<td>
			";

			//Interprety last login
			if ($v1['last_sign_in_stamp'] == '0'){
				echo "Never";
			}
			else {
				echo date("j M, Y", $v1['last_sign_in_stamp']);
			}
			echo "
			</td>

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

