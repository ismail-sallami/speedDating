<?php
require_once("../models/config.php");
//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: account.php"); die(); }
//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$email = trim($_POST["email"]);
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);
	$confirm_pass = trim($_POST["passwordc"]);
	$captcha = md5($_POST["captcha"]);

	if ($captcha != $_SESSION['captcha'])
	{
		$errors[] = lang("CAPTCHA_FAIL");
	}
	if(minMaxRange(5,25,$username))
	{
		$errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
	}elseif(!ctype_alnum($username)){
		$errors[] = lang("ACCOUNT_USER_INVALID_CHARACTERS");
	}

	if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
	{
		$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
	}
	else if($password != $confirm_pass)
	{
		$errors[] = lang("ACCOUNT_PASS_MISMATCH");
	}
	if(!isValidEmail($email))
	{
		$errors[] = lang("ACCOUNT_INVALID_EMAIL");
	}
	//End data validation
	if(count($errors) == 0)
	{
		//Construct a user object
		$user = new User($username,$password,$email);
		//Send  internal welcome message


		//Checking this flag tells us whether there were any errors such as possible data duplication occured
		if(!$user->status)
		{
			if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
			if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));
		}
		else
		{
			//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
			if(!$user->userCakeAddUser())
			{
				if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
				if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
			}
		}
	}
	if(count($errors) == 0) {
		$successes[] = $user->success;
		$welcome = sendInternalMessage($username,null,lang('WELCOME_TITLE'), lang('WELCOME_BODY'));
	}
}

require_once ('head.php');
?>
<link href="css/input_radio.css" rel="stylesheet">
<title>HitchMe &hearts; Create you new account</title>
<meta name="keywords" content="Hitchme register" />
<meta name="description" content="'Register and create your profile and join our events to meet your match.">

</head>
<body>

<?php
require_once 'header.php';
?>
<section id="portfolio">
	<div class="container">
		<div id='regbox' class="col-sm-6 col-md-offset-3">
			<h1>Create your account</h1>
			<h2>Please fill the form then complete your profile</h2>
			<?php
			echo resultBlock($errors,$successes);
			?>
			<div  id='error' class='alert alert-warning' hidden><?= lang('ACCEPT_TERMS'); ?></div>
			<form name='newUser' id="form" action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>

				<p>
					<label><?= lang('USERNAME'); ?>:</label>
					<input  class="form-control" type='text' name='username' />
				</p>
				<p>
					<label><?= lang('PASSWORD'); ?>:</label>
					<input  class="form-control" type='password' name='password' />
				</p>
				<p>
					<label><?= lang('CONFIRM'); ?>:</label>
					<input  class="form-control" type='password' name='passwordc' />
				</p>
				<p>
					<label><?= lang('EMAIL'); ?>:</label>
					<input  class="form-control" type='text' name='email' />
				</p>
				<p>
					<label><?= lang('SECURITY_CODE'); ?>:</label>
					<img src='models/captcha.php' alt="captcha">
				</p>
				<label><?= lang('ENTER_SECURITY'); ?>:</label>
				<input  class="form-control" name='captcha' type='text'>
				<br>
				<div id="checkbox">
					<div class="btn-group" data-toggle="buttons">
						<label class="btn">
							<input type="checkbox" name="accept" id="accept" ><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i>
						</label>

					</div><span> <?= lang('I_ACCEPT'); ?> <a href="<?= strtolower($lang['NAME']) ?>/terms.php"><?= lang('TERMS'); ?>.</a> </span>
				</div>
				<p></p>
				<input type='submit' class="btn btn-primary btn-lg" value='<?= lang('REGISTER'); ?>'/>

			</form>
		</div>
	</div>
</section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>
<script>
	$("#form").submit(function(e) {

		if(!$('input[type=checkbox]:checked').length) {
			$('#checkbox').css('border', 'solid 1px red');
			$("#error").show();
			return false;
		}

		return true;
	});


</script>

</body>
</html>
