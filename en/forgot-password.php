<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//User has confirmed they want their password changed
if(!empty($_GET["confirm"]))
{
	$token = trim($_GET["confirm"]);

	if($token == "" || !validateActivationToken($token,TRUE))
	{
		$errors[] = lang("FORGOTPASS_INVALID_TOKEN");
	}
	else
	{
		$rand_pass = getUniqueCode(15); //Get unique code
		$secure_pass = generateHash($rand_pass); //Generate random hash
		$userdetails = fetchUserDetails(NULL,NULL,$token); //Fetchs user details
		$mail = new userCakeMail();

		//Setup our custom hooks
		$hooks = array(
			"searchStrs" => array("#GENERATED-PASS#","#USERNAME#"),
			"subjectStrs" => array($rand_pass,$userdetails["email"])
			);

		if(!$mail->newTemplateMsg("your-lost-password.html",$hooks))
		{
			$errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
		}
		else
		{
			if(!$mail->sendMail($userdetails["email"],"Your new password"))
			{
				$errors[] = lang("MAIL_ERROR");
			}
			else
			{
				if(!updatePasswordFromToken($secure_pass,$token))
				{
					$errors[] = lang("SQL_ERROR");
				}
				else
				{
					if(!flagLostPasswordRequest($userdetails["email"],0))
					{
						$errors[] = lang("SQL_ERROR");
					}
					else {
						$successes[]  = lang("FORGOTPASS_NEW_PASS_EMAIL");
					}
				}
			}
		}
	}
}

//User has denied this request
if(!empty($_GET["deny"]))
{
	$token = trim($_GET["deny"]);

	if($token == "" || !validateActivationToken($token,TRUE))
	{
		$errors[] = lang("FORGOTPASS_INVALID_TOKEN");
	}
	else
	{

		$userdetails = fetchUserDetails(NULL, NULL, $token);

		if(!flagLostPasswordRequest($userdetails["email"],0))
		{
			$errors[] = lang("SQL_ERROR");
		}
		else {
			$successes[] = lang("FORGOTPASS_REQUEST_CANNED");
		}
	}
}

//Forms posted
if(!empty($_POST))
{
	$email = $_POST["email"];

	//Perform some validation
	//Feel free to edit / change as required

	if(trim($email) == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
	}
	//Check to ensure email is in the correct format / in the db
	else if(!isValidEmail($email) || !emailExists($email))
	{
		$errors[] = lang("ACCOUNT_INVALID_EMAIL");
	}

	if(count($errors) == 0)
	{

		//Check that the username / email are associated to the same account


			//Check if the user has any outstanding lost password requests
			$userdetails = fetchUserDetails($email);
			if($userdetails["lost_password_request"] == 1)
			{
				$errors[] = lang("FORGOTPASS_REQUEST_EXISTS");
			}
			else
			{
				//Email the user asking to confirm this change password request
				//We can use the template builder here

				//We use the activation token again for the url key it gets regenerated everytime it's used.

				$mail = new userCakeMail();
				$confirm_url = lang("CONFIRM")."<br>https://".$websiteUrl."en/forgot-password.php?confirm=".$userdetails["activation_token"];
				$deny_url = lang("DENY")."<br>https://".$websiteUrl."en/forgot-password.php?deny=".$userdetails["activation_token"];
				//Setup our custom hooks
				$hooks = array(
					"searchStrs" => array("#CONFIRM-URL#","#DENY-URL#","#USERNAME#"),
					"subjectStrs" => array($confirm_url,$deny_url,$userdetails["email"])
					);

				if(!$mail->newTemplateMsg("lost-password-request.html",$hooks))
				{
					$errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
				}
				else
				{
					if(!$mail->sendMail($userdetails["email"],"Lost password request"))
					{
						$errors[] = lang("MAIL_ERROR");
					}
					else
					{
						//Update the DB to show this account has an outstanding request
						if(!flagLostPasswordRequest($userdetails["email"],1))
						{
							$errors[] = lang("SQL_ERROR");
						}
						else {

							$successes[] = lang("FORGOTPASS_REQUEST_SUCCESS");
						}
					}
				}
			}

	}
}
require_once ('head.php');

echo "
<title>HitchMe &hearts; Password recovery</title>
<meta name=\"keywords\" content=\"Hitchme password recovery, forgot password\" />
<meta name=\"description\" content=\"'Recover your lost password.\">

</head><body>";
require_once 'header.php';
?>

<section id="portfolio">
	<div class="container">

<?= resultBlock($errors,$successes); ?>
			<div id='regbox'  class="col-md-4 col-md-offset-4">
			<h1>Forgot your password ?</h1>
				<p>We will send you a confirmation email then a temporary password. Please change the generated password to something you can remember.
				<br>If you have any issue, please contact us.</p>
			<form name='newLostPass' action='<?= $_SERVER['PHP_SELF'] ?>' method='post'>
			<h2>Email:</h2>
			<input type='text' class="form-control" name='email' />
			<br>
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


