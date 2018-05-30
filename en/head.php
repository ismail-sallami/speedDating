<?php
//Force the use of HTTPS
/*
if($_SERVER["HTTPS"] != "on")
{
header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
exit();
}

*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="language" content="de">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<meta name="author" content="HitchMe.de">
<link rel="alternate" hreflang="en" href="https://www.hitchme.de/en/" />

 <BASE href="https://<?= $_SERVER['HTTP_HOST']; ?>/">

<!-- core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/animate.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/icomoon.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="css/jquery.dataTables.min.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<script src='models/funcs.js' type='text/javascript'>



<![endif]-->

<link rel="shortcut icon" href="images/ico/favicon.ico">


