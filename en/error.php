<!DOCTYPE html>
<html lang="en">
<head>
<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once ('head.php');

?>

</head>
<body>

<?php
require_once 'header.php';
?>
    <section id="portfolio">
        <div class="container">
            <section id="error" class="container text-center">
                <img src="/images/404.png" alt="error404">
                <h1>Page not found</h1>
                <p><a class="btn btn-primary" href="en/index.php">GO BACK TO THE HOMEPAGE</a></p>
                <p>or contact the <a href="en/contact-us.php">administrator</a>.</p>
            </section><!--/#error-->
        </div>
    </section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>


</body>
</html>
