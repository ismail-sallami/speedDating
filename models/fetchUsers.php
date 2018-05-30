<?php
require_once("config.php");
$look_for = $_POST['look_for'];
$age_from = $_POST['age_from'];
$age_to = $_POST['age_to'];
$array = getProfilePicsList($look_for, $age_from, $age_to);
echo json_encode($array);