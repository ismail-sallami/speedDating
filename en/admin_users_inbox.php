<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once ('head.php');
?>

</head>
<body>

<?php
require_once 'header.php';
if(!empty($_POST)) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $id = $_GET['id'];
    if ($body!='')
    $response = sendInternalMessage(NULL, $id, $title, $body);
}
$messages = fetchUserMessages($_GET['id']);

?>
    <section id="portfolio">
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <?php
                if(!is_null($response))
                if( $response==TRUE){
                    echo '<div class="alert alert-success">Message sent successfully</div>';
                }else{
                    echo '<div class="alert alert-danger">An error has occured</div>';
                }
                ?>
                <form method="POST">
                    <input type="text" placeholder="Title" name="title" class="form-control" required><br>
                    <textarea rows="4" name="body" placeholder="Message" class="form-control" required></textarea><br>
                    <input  class="btn btn-default"  type="submit">
                </form>
                <hr>
            <?php
                foreach ($messages as $userMessage) {
                    echo '<div class="well well-sm"><i class="fa fa-calendar"></i>  '.$userMessage['timestamp'].'<br><b>'.$userMessage['title'].'</b><br>'.$userMessage['body'].'</div>';
                }
            ?>
            </div>

        </div>
    </section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>


</body>
</html>
