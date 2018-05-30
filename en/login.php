<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header('Location:account.php'); exit(); }
//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$username = sanitize(trim($_POST["username"]));
	$password = trim($_POST["password"]);

	//Perform some validation
	//Feel free to edit / change as required
	if($username == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
	}
	if($password == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
	}

	if(count($errors) == 0)
	{
		//A security note here, never tell the user which credential was incorrect
		if(!usernameExists($username))
		{
			$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
		}
		else
		{
			$userdetails = fetchUserDetails(NULL,$username);
			//See if the user's account is activated
			if($userdetails["active"]==0)
			{
				$errors[] = lang("ACCOUNT_INACTIVE");
			}
			else
			{
				//Hash the password and use the salt from the database to compare the password.
				$entered_pass = generateHash($password,$userdetails["password"]);

				if($entered_pass != $userdetails["password"])
				{
					//Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
					$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
				}
				else
				{

					//Passwords match! we're good to go'

					//Construct a new logged in user object
					//Transfer some db data to the session object
					$loggedInUser = new loggedInUser();
					$loggedInUser->email = $userdetails["email"];
					$loggedInUser->user_id = $userdetails["id"];
					$loggedInUser->hash_pw = $userdetails["password"];
					$loggedInUser->title = $userdetails["title"];
					$loggedInUser->username = $userdetails["user_name"];

					//Update last sign in
					$loggedInUser->updateLastSignIn();
					$_SESSION["userCakeUser"] = $loggedInUser;
					//Redirect to user account page
					header('Location:account.php');
					exit();
				}
			}
		}
	}
}
require_once ('head.php');
echo '
<title>HitchMe &hearts; Login and join HitchMe</title>
<meta name="keywords" content="Hitchme login, Hitchme signup" />
<meta name="description" content="Join our speed dating events and find your soulmate.">

</head><body>';
require_once 'header.php';
?>
<section id="portfolio">
	<div class="container">
		<div id='regbox'  class="col-md-4 col-md-offset-4 ">
			<?php
			if (isset($_SESSION['referer'])){
				echo '<div class="alert alert-info"><i class="icon icon-warning"></i>'.lang('PLEASE_LOGIN').'</div>';
			}
			?>
			<?= resultBlock($errors,$successes); ?>
			<form name='login' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
				<h1>Login or Singup</h1>
				<label><?= lang('USERNAME'); ?>:</label>
				<input type='text' class="form-control" name='username' />
				<label><?= lang('PASSWORD'); ?>:</label>
				<input type='password' class="form-control" name='password' />
				<br>
				<input type='submit'  class="btn btn-primary btn-lg" value='Login' class='submit' />
			</form>
			<ul>
				<li><?= lang('NO_ACCOUNT'); ?><a href='<?= strtolower($lang['NAME'])?>/register.php'><?= lang('REGISTER'); ?></a></li>
				<li><a href='<?= strtolower($lang['NAME']) ?>/forgot-password.php'><?= lang('FORGOT_PASSWORD'); ?></a></li>
			</ul>
		</div>
	</div>
</section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>

</body>
</html>


