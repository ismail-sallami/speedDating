<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once ('head.php');
$message = getMessage($_GET['id'],$loggedInUser->user_id);

if(!$message){
    header('Location: error.php'); die();
}
?>

</head>
<body>

<?php
require_once 'header.php';

?>
    <section id="portfolio">
        <div class="container">
            <div class="col-md-6 col-md-offset-3 get-started wow fadeInDown">
                <h3><?= $message['title'] ?></h3>
                <hr>
                <p><?= $message['body'] ?></p>
                <hr>
                <p><?= $message['timestamp'] ?></p>
            </div>
        </div>
    </section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>


</body>
</html>
