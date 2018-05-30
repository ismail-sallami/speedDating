<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once ('head.php');

?>
<link href="css/ninja-slider.css" rel="stylesheet" type="text/css" />
<script src="js/ninja-slider.js" type="text/javascript"></script>

</head>
<body>

<?php
require_once 'header.php';

?>
    <section id="portfolio">
        <div class="container">
            <div id="ninja-slider">
                <div class="slider-inner">
                    <ul>
                        <?php
                        $path    = 'images/profiles';
                        $files = scandir($path);
                        $files = array_diff(scandir($path), array('.', '..','thumbnail'));
                        foreach ($files as $pic){
                            echo '                            <li>
                                    <a class="ns-img" href="images/profiles/'.$pic.'"></a>
                                </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>


        </div>
    </section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>
<script src="js/usersCarousel.js"></script>



</body>
</html>
