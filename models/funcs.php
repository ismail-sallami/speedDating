<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

//Functions that do not interact with DB
//------------------------------------------------------------------------------

//Retrieve a list of all .php files in models/languages
function getLanguageFiles()
{
	$directory = "models/languages/";
	$languages = glob($directory . "*.php");
	//print each file name
	return $languages;
}

//Retrieve a list of all .css files in models/site-templates 
function getTemplateFiles()
{
	$directory = "models/site-templates/";
	$languages = glob($directory . "*.css");
	//print each file name
	return $languages;
}

//Retrieve a list of all .php files in root files folder
function getPageFiles()
{
	$directory = "";
	$pages = glob($directory . "*.php");
	//print each file name
	foreach ($pages as $page){
		$row[$page] = $page;
	}
	return $row;
}

//Destroys a session as part of logout
function destroySession($name)
{
	if(isset($_SESSION[$name]))
	{
		$_SESSION[$name] = NULL;
		unset($_SESSION[$name]);
	}
}

//Generate a unique code
function getUniqueCode($length = "")
{	
	$code = md5(uniqid(rand(), true));
	if ($length != "") return substr($code, 0, $length);
	else return $code;
}

//Generate an activation key
function generateActivationToken($gen = null)
{
	do
	{
		$gen = md5(uniqid(mt_rand(), false));
	}
	while(validateActivationToken($gen));
	return $gen;
}

//@ Thanks to - http://phpsec.org
function generateHash($plainText, $salt = null)
{
	if ($salt === null)
	{
		$salt = substr(md5(uniqid(rand(), true)), 0, 25);
	}
	else
	{
		$salt = substr($salt, 0, 25);
	}
	
	return $salt . sha1($salt . $plainText);
}

//Checks if an email is valid
function isValidEmail($email)
{
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return true;
	}
	else {
		return false;
	}
}

//Inputs language strings from selected language.
function lang($key,$markers = NULL)
{
	global $lang;
	if($markers == NULL)
	{
		$str = $lang[$key];
	}
	else
	{
		//Replace any dyamic markers
		$str = $lang[$key];
		$iteration = 1;
		foreach($markers as $marker)
		{
			$str = str_replace("%m".$iteration."%",$marker,$str);
			$iteration++;
		}
	}
	//Ensure we have something to return
	if($str == "")
	{
		return ("No language key found");
	}
	else
	{
		return $str;
	}
}

//Checks if a string is within a min and max length
function minMaxRange($min, $max, $what)
{
	if(strlen(trim($what)) < $min)
		return true;
	else if(strlen(trim($what)) > $max)
		return true;
	else
	return false;
}

//Replaces hooks with specified text
function replaceDefaultHook($str)
{
	global $default_hooks,$default_replace;	
	return (str_replace($default_hooks,$default_replace,$str));
}

//Displays error and success messages
function resultBlock($errors,$successes){
	//Error block
	if(count($errors) > 0)
	{
		echo "<div  id='result' class='alert alert-danger'>";
		foreach($errors as $error)
		{
			echo "<p>".$error."</p>";
		}
		echo "</div>";
	}
	//Success block
	if(count($successes) > 0)
	{
		echo "<div id='result' class='alert alert-success'>";
		foreach($successes as $success)
		{
			echo "<p>".$success."</p>";
		}
		echo "</div>";
	}
}

//Completely sanitizes text
function sanitize($str)
{
	return strtolower(strip_tags(trim(($str))));
}

//Functions that interact mainly with .users table
//------------------------------------------------------------------------------

//Delete a defined array of users
function deleteUsers($users) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."users 
		WHERE id = ?");
	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE user_id = ?");
	$stmt3 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."users_details
		WHERE id = ?");

	foreach($users as $id){
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt2->bind_param("s", $id);
		$stmt2->execute();
		$stmt3->bind_param("i", $id);
		$stmt3->execute();

		$i++;
	}
	$stmt->close();
	$stmt2->close();
	return $i;
}

//Check if an email exists in the DB
function emailExists($email)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		email = ?
		LIMIT 1");
	$stmt->bind_param("s", $email);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if a user name and email belong to the same user
function emailUsernameLinked($email,$username)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE user_name = ?
		AND
		email = ?
		LIMIT 1
		");
	$stmt->bind_param("ss", $username, $email);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Retrieve information for all users
function fetchAllUsers()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		user_name,
		password,
		email,
		activation_token,
		last_activation_request,
		lost_password_request,
		active,
		title,
		sign_up_stamp,
		last_sign_in_stamp
		FROM ".$db_table_prefix."users");
	$stmt->execute();
	$stmt->bind_result($id, $user, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $signUp, $signIn);
	
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_name' => $user, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);
	}
	$stmt->close();
	return ($row);
}
//Retrieve messages for all users or one user_id
function fetchUserMessages($user_id)
{
	global $mysqli;
	$stmt = $mysqli->prepare("SELECT id, title, timestamp,`read`, body FROM user_messages
								WHERE
								user_id = ?
								AND
								archived=0
								ORDER BY timestamp DESC");
	$stmt->bind_param("s", $user_id);
	$stmt->execute();
	$stmt->bind_result($id, $title, $timestamp, $read, $body );
	$row =[];
	while ($stmt->fetch()){
		$row[] = array('id' => $id,'title' => $title, 'timestamp' => $timestamp, 'read' => $read, 'body' =>$body);
	}
	$stmt->close();
	return ($row);
}
//get single message
function getMessage($message_id, $user_id){
	global $mysqli;
	$stmt0 = $mysqli->prepare("UPDATE user_messages
								SET `read`=1
								WHERE
								user_id = ?
								AND
								id = ?");
	$stmt0->bind_param("is", $user_id, $message_id);
	$stmt0->execute();

	$stmt = $mysqli->prepare("SELECT title, body, timestamp FROM user_messages
								WHERE
								user_id = ?
								AND
								id = ?");
	$stmt->bind_param("ii", $user_id, $message_id);
	$stmt->execute();
	$stmt->bind_result($title, $body, $timestamp );
	$message="";
	while ($stmt->fetch()){
		$message = array('title' => $title, 'body' => $body , 'timestamp' => $timestamp);
	}
	$stmt->close();
	return ($message);

}
//Delete message
function deleteMessages($messages) {
	global $mysqli;
	$i = 0;
	$stmt = $mysqli->prepare("UPDATE user_messages
	 						SET archived=1
	 						WHERE id = ?");
	foreach($messages as $id){
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}
//Get number of unread message
function getUnreadMessage($user_id){
	global $mysqli;
	$stmt = $mysqli->prepare("SELECT COUNT(*) unreadMessages FROM user_messages
								WHERE
								user_id = ?
								AND
								`read`=0");
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	$stmt->bind_result($unreadMessages );
	while ($stmt->fetch()){
		$unread = $unreadMessages;
	}
	$stmt->close();
	return ($unread);

}

//Retrieve complete user information by username, token or ID
function fetchUserDetails($email=NULL,$username=NULL,$token=NULL, $id=NULL)
{	if($email!=NULL) {
	$column = "email";
	$data = $email;
	}
	elseif($username!=NULL) {
		$column = "user_name";
		$data = $username;
	}
	elseif($token!=NULL) {
		$column = "activation_token";
		$data = $token;
	}
	elseif($id!=NULL) {
		$column = "id";
		$data = $id;
	}
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT
		id,
		user_name,
		password,
		email,
		activation_token,
		last_activation_request,
		lost_password_request,
		active,
		title,
		sign_up_stamp,
		last_sign_in_stamp
		FROM ".$db_table_prefix."users
		WHERE
		$column = ?
		LIMIT 1");
		$stmt->bind_param("s", $data);
	
	$stmt->execute();
	$stmt->bind_result($id, $user,  $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $signUp, $signIn);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'user_name' => $user, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);
	}
	$stmt->close();
	return ($row);
}

//Toggle if lost password request flag on or off
function flagLostPasswordRequest($email,$value)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET lost_password_request = ?
		WHERE
		email = ?
		LIMIT 1
		");
	$stmt->bind_param("ss", $value, $email);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//Check if a user is logged in
function isUserLoggedIn()
{
	global $loggedInUser,$mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT 
		id,
		password
		FROM ".$db_table_prefix."users
		WHERE
		id = ?
		AND 
		password = ? 
		AND
		active = 1
		LIMIT 1");
	$stmt->bind_param("is", $loggedInUser->user_id, $loggedInUser->hash_pw);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if($loggedInUser == NULL)
	{
		return false;
	}
	else
	{
		if ($num_returns > 0)
		{
			return true;
		}
		else
		{
			destroySession("userCakeUser");
			return false;	
		}
	}
}

//Change a user from inactive to active
function setUserActive($token)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET active = 1
		WHERE
		activation_token = ?
		LIMIT 1");
	$stmt->bind_param("s", $token);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Update user's profile
function updateProfile($user_id, $fname, $lname, $bdate, $phone, $gender, $eyes, $hair, $height, $marital, $kids, $smoking, $drinking, $hobbies, $books, $music, $movies, $aboutme, $profile_pic)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."users_details
			(id, fname, lname, bdate, phone, gender, eyes, hair, height, marital, kids, smoking, drinking, hobbies, books, music, movies, aboutme, profile_pic)
			VALUES
		  	(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		 	 ON DUPLICATE KEY UPDATE
			fname = VALUES(fname),
			lname = VALUES(lname),
			bdate = VALUES(bdate),
			phone = VALUES(phone),
			gender = VALUES(gender),
			eyes = VALUES(eyes),
			hair = VALUES(hair),
			height = VALUES(height),
			marital = VALUES(marital),
			kids = VALUES(kids),
			smoking = VALUES(smoking),
			drinking = VALUES(drinking),
			hobbies = VALUES(hobbies),
			books = VALUES(books),
			music = VALUES(music),
			movies = VALUES(movies),
			aboutme= VALUES(aboutme),
			profile_pic= VALUES(profile_pic)
			");
	$stmt->bind_param("sssssssssssssssssss", $user_id, $fname, $lname, $bdate, $phone, $gender, $eyes, $hair, $height, $marital, $kids, $smoking, $drinking, $hobbies, $books, $music,  $movies, $aboutme, $profile_pic);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//Update a user's email
function updateEmail($id, $email)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET 
		email = ?
		WHERE
		id = ?");
	$stmt->bind_param("si", $email, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Input new activation token, and update the time of the most recent activation request
function updateLastActivationRequest($new_activation_token,$username,$email)
{
	global $mysqli,$db_table_prefix; 	
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET activation_token = ?,
		last_activation_request = ?
		WHERE email = ?
		AND
		user_name = ?");
	$stmt->bind_param("ssss", $new_activation_token, time(), $email, $username);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Generate a random password, and new token
function updatePasswordFromToken($pass,$token)
{
	global $mysqli,$db_table_prefix;
	$new_activation_token = generateActivationToken();
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET password = ?,
		activation_token = ?
		WHERE
		activation_token = ?");
	$stmt->bind_param("sss", $pass, $new_activation_token, $token);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Update a user's title
function updateTitle($id, $title)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET 
		title = ?
		WHERE
		id = ?");
	$stmt->bind_param("si", $title, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Check if a user ID exists in the DB
function userIdExists($id)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Checks if a username exists in the DB
function usernameExists($username)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		user_name = ?
		LIMIT 1");
	$stmt->bind_param("s", $username);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if activation token exists in DB
function validateActivationToken($token,$lostpass=NULL, $confirmation=NULL)
{
	global $mysqli,$db_table_prefix;
	if ($confirmation){
		$stmt = $mysqli->prepare("SELECT active
			FROM ".$db_table_prefix."users
			WHERE
			activation_token = ?
			LIMIT 1");
	}else{
		if($lostpass == NULL)
		{
			$stmt = $mysqli->prepare("SELECT active
			FROM ".$db_table_prefix."users
			WHERE active = 0
			AND
			activation_token = ?
			LIMIT 1");
		}
		else
		{
			$stmt = $mysqli->prepare("SELECT active
			FROM ".$db_table_prefix."users
			WHERE active = 1
			AND
			activation_token = ?
			AND
			lost_password_request = 1
			LIMIT 1");
		}
	}
	$stmt->bind_param("s", $token);
	$stmt->execute();
	$stmt->store_result();
		$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Functions that interact mainly with .permissions table
//------------------------------------------------------------------------------

//Create a permission level in DB
function createPermission($permission) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permissions (
		name
		)
		VALUES (
		?
		)");
	$stmt->bind_param("s", $permission);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Delete a permission level from the DB
function deletePermission($permission) {
	global $mysqli,$db_table_prefix,$errors; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permissions 
		WHERE id = ?");
	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE permission_id = ?");
	$stmt3 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE permission_id = ?");
	foreach($permission as $id){
		if ($id == 1){
			$errors[] = lang("CANNOT_DELETE_NEWUSERS");
		}
		elseif ($id == 2){
			$errors[] = lang("CANNOT_DELETE_ADMIN");
		}
		else{
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt2->bind_param("i", $id);
			$stmt2->execute();
			$stmt3->bind_param("i", $id);
			$stmt3->execute();
			$i++;
		}
	}
	$stmt->close();
	$stmt2->close();
	$stmt3->close();
	return $i;
}

//Retrieve information for all permission levels
function fetchAllPermissions()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		name
		FROM ".$db_table_prefix."permissions");
	$stmt->execute();
	$stmt->bind_result($id, $name);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'name' => $name);
	}
	$stmt->close();
	return ($row);
}

//Retrieve information for a single permission level
function fetchPermissionDetails($id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		name
		FROM ".$db_table_prefix."permissions
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($id, $name);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'name' => $name);
	}
	$stmt->close();
	return ($row);
}

//Check if a permission level ID exists in the DB
function permissionIdExists($id)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT id
		FROM ".$db_table_prefix."permissions
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if a permission level name exists in the DB
function permissionNameExists($permission)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT id
		FROM ".$db_table_prefix."permissions
		WHERE
		name = ?
		LIMIT 1");
	$stmt->bind_param("s", $permission);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Change a permission level's name
function updatePermissionName($id, $name)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."permissions
		SET name = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $name, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Functions that interact mainly with .user_permission_matches table
//------------------------------------------------------------------------------

//Match permission level(s) with user(s)
function addPermission($permission, $user) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_permission_matches (
		permission_id,
		user_id
		)
		VALUES (
		?,
		?
		)");
	if (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("is", $id, $user);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($user)){
		foreach($user as $id){
			$stmt->bind_param("is", $permission, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("is", $permission, $user);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Retrieve information for all user/permission level matches
function fetchAllMatches()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		user_id,
		permission_id
		FROM ".$db_table_prefix."user_permission_matches");
	$stmt->execute();
	$stmt->bind_result($id, $user, $permission);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_id' => $user, 'permission_id' => $permission);
	}
	$stmt->close();
	return ($row);	
}

//Retrieve list of permission levels a user has
function fetchUserPermissions($user_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT
		id,
		permission_id
		FROM ".$db_table_prefix."user_permission_matches
		WHERE user_id = ?
		");
	$stmt->bind_param("s", $user_id);
	$stmt->execute();
	$stmt->bind_result($id, $permission);
	while ($stmt->fetch()){
		$row[$permission] = array('id' => $id, 'permission_id' => $permission);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Retrieve list of users who have a permission level
function fetchPermissionUsers($permission_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT id, user_id
		FROM ".$db_table_prefix."user_permission_matches
		WHERE permission_id = ?
		");
	$stmt->bind_param("i", $permission_id);	
	$stmt->execute();
	$stmt->bind_result($id, $user);
	while ($stmt->fetch()){
		$row[$user] = array('id' => $id, 'user_id' => $user);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Unmatch permission level(s) from user(s)
function removePermission($permission, $user) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE permission_id = ?
		AND user_id =?");
	if (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $id, $user);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($user)){
		foreach($user as $id){
			$stmt->bind_param("ii", $permission, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $user);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Functions that interact mainly with .configuration table
//------------------------------------------------------------------------------

//Update configuration table
function updateConfig($id, $value)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."configuration
		SET 
		value = ?
		WHERE
		id = ?");
	foreach ($id as $cfg){
		$stmt->bind_param("si", $value[$cfg], $cfg);
		$stmt->execute();
	}
	$stmt->close();	
}

//Functions that interact mainly with .pages table
//------------------------------------------------------------------------------

//Add a page to the DB
function createPages($pages) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."pages (
		page
		)
		VALUES (
		?
		)");
	foreach($pages as $page){
		$stmt->bind_param("s", $page);
		$stmt->execute();
	}
	$stmt->close();
}

//Delete a page from the DB
function deletePages($pages) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."pages 
		WHERE id = ?");
	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE page_id = ?");
	foreach($pages as $id){
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt2->bind_param("i", $id);
		$stmt2->execute();
	}
	$stmt->close();
	$stmt2->close();
}

//Fetch information on all pages
function fetchAllPages()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		private
		FROM ".$db_table_prefix."pages");
	$stmt->execute();
	$stmt->bind_result($id, $page, $private);
	while ($stmt->fetch()){
		$row[$page] = array('id' => $id, 'page' => $page, 'private' => $private);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Fetch information for a specific page
function fetchPageDetails($id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		private
		FROM ".$db_table_prefix."pages
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($id, $page, $private);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'page' => $page, 'private' => $private);
	}
	$stmt->close();
	return ($row);
}

//Check if a page ID exists
function pageIdExists($id)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT private
		FROM ".$db_table_prefix."pages
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->store_result();	
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Toggle private/public setting of a page
function updatePrivate($id, $private)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."pages
		SET 
		private = ?
		WHERE
		id = ?");
	$stmt->bind_param("ii", $private, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Functions that interact mainly with .permission_page_matches table
//------------------------------------------------------------------------------

//Match permission level(s) with page(s)
function addPage($page, $permission) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permission_page_matches (
		permission_id,
		page_id
		)
		VALUES (
		?,
		?
		)");
	if (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $id, $page);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($page)){
		foreach($page as $id){
			$stmt->bind_param("ii", $permission, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $page);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Retrieve list of permission levels that can access a page
function fetchPagePermissions($page_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT
		id,
		permission_id
		FROM ".$db_table_prefix."permission_page_matches
		WHERE page_id = ?
		");
	$stmt->bind_param("i", $page_id);	
	$stmt->execute();
	$stmt->bind_result($id, $permission);
	while ($stmt->fetch()){
		$row[$permission] = array('id' => $id, 'permission_id' => $permission);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Retrieve list of pages that a permission level can access
function fetchPermissionPages($permission_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT
		id,
		page_id
		FROM ".$db_table_prefix."permission_page_matches
		WHERE permission_id = ?
		");
	$stmt->bind_param("i", $permission_id);	
	$stmt->execute();
	$stmt->bind_result($id, $page);
	while ($stmt->fetch()){
		$row[$page] = array('id' => $id, 'permission_id' => $page);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Unmatched permission and page
function removePage($page, $permission) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE page_id = ?
		AND permission_id =?");
	if (is_array($page)){
		foreach($page as $id){
			$stmt->bind_param("ii", $id, $permission);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $page, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("is", $permission, $user);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Check if a user has access to a page
function securePage($uri){

	//Separate document name from uri
	$tokens = explode('/', $uri);
	$page = $tokens[sizeof($tokens)-1];
	global $mysqli,$db_table_prefix,$loggedInUser;
	//retrieve page details
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		private
		FROM ".$db_table_prefix."pages
		WHERE
		page = ?
		LIMIT 1");
	$stmt->bind_param("s", $page);
	$stmt->execute();
	$stmt->bind_result($id, $page, $private);
	while ($stmt->fetch()){
		$pageDetails = array('id' => $id, 'page' => $page, 'private' => $private);
	}
	$stmt->close();
	//If page does not exist in DB, allow access
	if (empty($pageDetails)){
		return true;
	}
	//If page is public, allow access
	elseif ($pageDetails['private'] == 0) {
		return true;	
	}
	//If user is not logged in, deny access
	elseif(!isUserLoggedIn()) 
	{
		header("Location: login.php");
		return false;
	}
	else {
		//Retrieve list of permission levels with access to page
		$stmt = $mysqli->prepare("SELECT
			permission_id
			FROM ".$db_table_prefix."permission_page_matches
			WHERE page_id = ?
			");
		$stmt->bind_param("i", $pageDetails['id']);	
		$stmt->execute();
		$stmt->bind_result($permission);
		while ($stmt->fetch()){
			$pagePermissions[] = $permission;
		}
		$stmt->close();
		//Check if user's permission levels allow access to page
		if ($loggedInUser->checkPermission($pagePermissions)){ 
			return true;
		}
		//Grant access if master user
		elseif ($loggedInUser->user_id == $master_account){
			return true;
		}
		else {
			header("Location: account.php");
			return false;	
		}
	}
}


/*--------------------------
Dating function
----------------------------*/
//Add a new dating event
function AddEvent($date, $location, $city)
{
	global $mysqli;
	$stmt = $mysqli->prepare("INSERT INTO dating_event VALUES ('',?,?,?)");
	$stmt->bind_param("sss", $date, $location, $city);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//Add a new dating event
function AddSprint($event_id, $time, $lang, $w_places, $m_places, $price, $age_from, $age_to)
{
	global $mysqli;
	$stmt = $mysqli->prepare("INSERT INTO dating_sprint VALUES ('', ?, ?, ?, ?,'','', ?, ?, ?, ?,'OPEN')");
	$stmt->bind_param("isiiiiis",$event_id, $time, $m_places, $w_places, $price, $age_from, $age_to, $lang  );
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//Fetch all Events
//$valid var is to display all events or only the valid
//TIME_FORMAT(time, '%H:%i') as time is to remove the seconds part
function fetchAllSprints($valid)
{
	global $mysqli;
	if ($valid){
		$stmt = $mysqli->prepare("SELECT S.id, event_id, date, location, TIME_FORMAT(time, '%H:%i') as time, m_available, m_booked, w_available, w_booked, price, age_min, age_max, lang, status
 								  FROM dating_event E, dating_sprint S
 								  WHERE E.id = S.event_id AND date >= CURDATE() AND status='OPEN' ");
	}else{
		$stmt = $mysqli->prepare("SELECT S.id, event_id, date, location, TIME_FORMAT(time, '%H:%i') as time, m_available, m_booked, w_available, w_booked, price, age_min, age_max, lang, status
 								  FROM dating_event E, dating_sprint S
 								  WHERE E.id = S.event_id ");
	}
	$stmt->execute();
	$stmt->bind_result($sprint_id, $event_id, $date, $location, $time, $m_available, $m_booked, $w_available, $w_booked, $price, $age_min, $age_max, $sprint_lang, $status);
	$eventRow = array();
	$sprintRow = array();
	$fullRow = array();
	while ($stmt->fetch()){
		$eventRow[] = array('event_id' => $event_id, 'date' => $date, 'location' => $location);
		$sprintRow[] = array('sprint_id' => $sprint_id,'event_id' => $event_id, 'time' => $time, 'm_available' => $m_available, 'm_booked' => $m_booked, 'w_available' => $w_available, 'w_booked' => $w_booked, 'price' => $price, 'age_min' => $age_min, 'age_max' => $age_max, 'sprint_lang' => $sprint_lang, 'status' => $status);
		$fullRow[] = array('event_id' => $event_id, 'date' => $date, 'location' => $location, 'sprint_id' => $sprint_id, 'time' => $time, 'm_available' => $m_available, 'm_booked' => $m_booked, 'w_available' => $w_available, 'w_booked' => $w_booked, 'price' => $price, 'age_min' => $age_min, 'age_max' => $age_max, 'sprint_lang' => $sprint_lang, 'status' => $status);

	}
	$stmt->close();
	return array($eventRow, $sprintRow, $fullRow);
}
function fetchSprint($id)
{
	global $mysqli;
		$stmt = $mysqli->prepare("SELECT S.id, event_id, date, location, city, TIME_FORMAT(time, '%H:%i') as time, m_available, m_booked, w_available, w_booked, price, age_min, age_max, lang
 								  FROM dating_event E, dating_sprint S
 								  WHERE E.id = S.event_id AND S.id= ? ");
	$stmt->bind_param("i",$id);
	$stmt->execute();
	$stmt->bind_result($sprint_id, $event_id, $date, $location, $city, $time, $m_available, $m_booked, $w_available, $w_booked, $price, $age_min, $age_max, $sprint_lang);
	while ($stmt->fetch()){
		$sprintRow = array('event_id' => $event_id, 'date' => $date, 'location' => $location, 'city' => $city, 'sprint_id' => $sprint_id, 'time' => $time, 'm_available' => $m_available, 'm_booked' => $m_booked, 'w_available' => $w_available, 'w_booked' => $w_booked, 'price' => $price, 'age_min' => $age_min, 'age_max' => $age_max, 'sprint_lang' => $sprint_lang);
	}
	$stmt->close();
	return ( $sprintRow);
}
//Get the list of profile pictures of all users
function getProfilePicsList($look_for=NULL, $age_from=NULL, $age_to=NULL)
{
	global $mysqli,$db_table_prefix;
	if ($look_for){
		$stmt = $mysqli->prepare("SELECT id, profile_pic FROM ".$db_table_prefix."users_details
								WHERE
								gender= ?
								AND
								TIMESTAMPDIFF(YEAR, bdate, CURDATE()) between ? and ?
								");
		$stmt->bind_param("sii",$look_for, $age_from, $age_to);
	}else{
		$stmt = $mysqli->prepare("SELECT id, profile_pic FROM ".$db_table_prefix."users_details  ");
	}
	$stmt->execute();
	$stmt->bind_result($user_id, $profile_pic);
	while ($stmt->fetch()){
		$ProfilePicsList[] = array('user_id' => $user_id, 'profile_pic' => $profile_pic);
	}
	$stmt->close();
	return ($ProfilePicsList);
}
//Sprint participants
function fetchSprintParticipants($sprint_id)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT user_id, fname, lname, bdate, phone, gender, eyes, hair, height, marital, kids, profile_pic
 								  FROM ".$db_table_prefix."users_details , sprint_speeddaters S
 								  WHERE user_id = id AND sprint_id= ? ");
	$stmt->bind_param("i",$sprint_id);
	$stmt->execute();
	$stmt->bind_result($user_id, $fname, $lname, $bdate, $phone, $gender, $eyes, $hair, $height, $marital, $kids, $profile_pic);
	$Participants=array();
	while ($stmt->fetch()){
		$Participants[] = array('user_id' => $user_id, 'fname' => $fname, 'lname' => $lname, 'bdate' => $bdate, 'phone' => $phone, 'gender' => $gender, 'eyes' => $eyes, 'hair' => $hair, 'height' => $height, 'marital' => $marital, 'kids' => $kids, 'profile_pic' => $profile_pic);
	}
	$stmt->close();
	return ($Participants);
}

//user sprints
function fetchUserSprints($user_id)
{
	global $mysqli;
	$stmt = $mysqli->prepare("SELECT sprint_id, time, date
 								  FROM sprint_speeddaters D, dating_sprint S, dating_event E
 								  WHERE D.user_id = ?
							   	  AND sprint_id = S.id
							   	  AND S.event_id = E.id");
	$stmt->bind_param("s",$user_id);
	$stmt->execute();
	$stmt->bind_result($sprint_id, $sprint_time, $sprint_date);
	$my_sprints=array();
	while ($stmt->fetch()){
		$my_sprints[] = array('sprint_id' => $sprint_id,'sprint_time' => $sprint_time, 'sprint_date' => $sprint_date);
	}
	$stmt->close();
	return ($my_sprints);
}


//Fetch user profile
function fetchUserProfile($id)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT * FROM ".$db_table_prefix."users_details
		WHERE
		id = ?
		");
	$stmt->bind_param("s", $id);
	$stmt->execute();
	$stmt->bind_result($user_id, $fname, $lname, $bdate, $phone, $gender, $eyes, $hair, $height, $marital, $kids, $smoking, $drinking, $hobbies, $books, $music, $movies, $aboutme, $profile_pic);
	$row=[];
	while ($stmt->fetch()){
		$row = array('user_id' => $user_id, 'fname' => $fname, 'lname' => $lname, 'bdate' => $bdate, 'phone' => $phone, 'gender' => $gender, 'eyes' => $eyes, 'hair' => $hair, 'height' => $height, 'marital' => $marital, 'kids' => $kids, 'smoking' => $smoking, 'drinking' => $drinking, 'hobbies' => $hobbies, 'books' => $books, 'music' => $music, 'movies' => $movies, 'aboutme' => $aboutme, 'profile_pic' => $profile_pic);
	}
	$stmt->close();
	return ($row);
}

//Insert a new speeddating booking
function bookSprint($user_id, $guest_id = null, $sprint_id)
{
	global $mysqli;
	if ($guest_id){
		$stmt = $mysqli->prepare("INSERT INTO sprint_speeddaters (user_id, guest_id, sprint_id)
			VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $user_id, $guest_id,  $sprint_id);

	}else{
		$stmt = $mysqli->prepare("INSERT INTO sprint_speeddaters (user_id, sprint_id)
			VALUES (?, ?)");
		$stmt->bind_param("ss", $user_id, $sprint_id);
		updateAvailability($user_id, $sprint_id, 1);
	}
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//get user Gender
function getGender ($user_id){
	global $mysqli, $db_table_prefix;
	return $mysqli->query("SELECT gender FROM ".$db_table_prefix."users_details WHERE id ='".$user_id ."'")->fetch_object()->gender;
}

//update availability
function updateAvailability($user_id, $sprint_id, $value){
	global $mysqli;
	$userGender= getGender ($user_id);
	if ($userGender=="male"){
		$stmt = $mysqli->prepare("UPDATE dating_sprint
		SET m_booked = m_booked + ?
		WHERE
		id = ?
		");
	}else{
		$stmt = $mysqli->prepare("UPDATE dating_sprint
		SET m_booked = w_booked + ?
		WHERE
		id = ?
		");
	}
	$stmt->bind_param("is", $value, $sprint_id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
//Cancel sprint booking
function cancelSprint($user_id, $sprint_id) {
	global $mysqli;
	$stmt = $mysqli->prepare("DELETE FROM sprint_speeddaters
							WHERE user_id = ?
							AND
							sprint_id = ?");
	$stmt->bind_param("ss", $user_id, $sprint_id);
	$result = $stmt->execute();
	$stmt->close();
	updateAvailability($user_id, $sprint_id, -1);
	return $result;
}

//delete a sprint
function deleteSprints($sprints) {
	global $mysqli;
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM dating_sprint WHERE id = ?");
	foreach($sprints as $id){
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//save a match
function saveMatch ($sprint_id, $match1, $match2){
	global $mysqli;
	$stmt = $mysqli->prepare("INSERT INTO dating_match VALUES (?, ?, ?)");
	$stmt->bind_param("iss", $sprint_id, $match1, $match2);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
//check matches

function checkMatches ($sprint_id, $match1, $match2){
	global $mysqli;
	$stmt = $mysqli->prepare("SELECT * FROM dating_match WHERE sprint_id = ? AND match_2 = ? AND match_1 = ?");
	$stmt->bind_param("iss", $sprint_id, $match1, $match2);
	$stmt->execute();
	$stmt->store_result();
	$result =  $stmt->num_rows;
	$stmt->close();
	return $result;
}

//get matches list
function getMatchesList ($user_id){
	global $mysqli;
	$stmt = $mysqli->prepare("
					SELECT match_2
					FROM  dating_match
					WHERE match_1 =?
					AND match_2
					IN (SELECT match_1
						FROM  dating_match
						WHERE match_2 =?
					)
		");
	$stmt->bind_param("ii", $user_id, $user_id);
	$stmt->execute();
	$stmt->bind_result($match);
	$row=array();
	while ($stmt->fetch()){
		$row[] = array('match_id' => $match);
	}
	$stmt->close();
	return ($row);
}

//decide rates for a sprint
function decideSprint ($user_id, $sprint_id){
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE sprint_speeddaters
		SET decided = 'yes'
		WHERE
		user_id = ?
		AND
		sprint_id = ?
		");
	$stmt->bind_param("ii", $user_id, $sprint_id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//Get sprint decision
function getSprintDecision($user_id, $sprint_id){
	global $mysqli;
	$stmt = $mysqli->prepare("SELECT decided FROM sprint_speeddaters
		WHERE
		user_id = ?
		AND
		sprint_id = ?

		");
	$stmt->bind_param("ii", $user_id, $sprint_id);
	$stmt->execute();
	$stmt->bind_result($decided);
	$stmt->fetch();
	return ($decided);
}

//For Cron
function listToRemind(){
	global $mysqli;
	$stmt = $mysqli->prepare("
					SELECT fname,email,lang, DATE, TIME, location
					FROM dating_event, dating_sprint, sprint_speeddaters, uc_users_details, uc_users
					WHERE DATE = CURDATE()
					AND dating_event.id = dating_sprint.event_id
					AND sprint_speeddaters.sprint_id = dating_sprint.id
					AND uc_users_details.id = sprint_speeddaters.user_id
					AND uc_users_details.id =  uc_users.id
					");
	$stmt->execute();
	$stmt->bind_result($fname, $email, $lang, $date, $time, $location );
	$row=array();
	while ($stmt->fetch()){
		$row[] = array('fname' => $fname, 'email' => $email, 'lang' => $lang, 'date' => $date, 'time' => $time, 'location' => $location);
	}
	$stmt->close();
	return ($row);

}

//send internal message
function sendInternalMessage($username = NULL, $user_id =NULL, $title, $body){
	global $mysqli, $db_table_prefix;
	if ($username){
		$stmt = $mysqli->prepare("
						INSERT INTO user_messages (user_id,title,body)
						VALUES
						(
						(SELECT id FROM ".$db_table_prefix."users WHERE user_name = ? )
						, ?
						, ?)
						");
		$stmt->bind_param("sss", $username, $title, $body);
	}else{
		$stmt = $mysqli->prepare("
						INSERT INTO user_messages (user_id,title,body)
						VALUES (?, ?, ?)
						");
		$stmt->bind_param("sss", $user_id, $title, $body);

	}
	$result = $stmt->execute();
	$stmt->close();

	return $result;
}
//Upload Image file
function uploadImageFile($user_id) { // Note: GD library is required for this function

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$iWidth = $iHeight = 400; // desired image result dimensions
		$iJpgQuality = 100;

		if ($_FILES) {

// if no errors and size less than 250kb
			if (! $_FILES['image_file']['error']) {
				if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {

// new unique filename
					$uploaddir = '../images/profiles/'.$user_id.'/';
					if (!is_dir($uploaddir) && !mkdir($uploaddir)){
						die("Error creating folder $uploaddir");
					}

					$sTempFileName = $uploaddir. md5(time().rand());

// move uploaded file into cache folder
					move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);

// change file permission to 644
					@chmod($sTempFileName, 0644);

					if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
						$aSize = getimagesize($sTempFileName); // try to obtain image info
						if (!$aSize) {
							@unlink($sTempFileName);
							return;
						}

// check for image type
						switch($aSize[2]) {
							case IMAGETYPE_JPEG:
								$sExt = '.jpg';

// create a new image from file
								$vImg = @imagecreatefromjpeg($sTempFileName);
								break;
							case IMAGETYPE_PNG:
								$sExt = '.png';

// create a new image from file
								$vImg = @imagecreatefrompng($sTempFileName);
								break;
							default:
								@unlink($sTempFileName);
								return;
						}

// create a new true color image
						$vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );

// copy and resize part of an image with resampling
						imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);

// define a result image filename
						$sResultFileName = $sTempFileName . $sExt;

// output image to file
						imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
						@unlink($sTempFileName);

						return $sResultFileName;
					}
				}
			}
		}
	}
}
