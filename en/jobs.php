<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once ('head.php');

?>
<title>HitchMe &hearts; Job portal</title>
<meta name="keywords" content="Hitchme jobs, Hitchme career, moderator, hitchme noderator" />
<meta name="description" content="Hitchme job offers. Moderator, assistants, events organisers and more.">

</head>
<body>

<?php
require_once 'header.php';

?>
    <section id="portfolio">
        <div class="container">
            <h1>Work with us</h1>
            <h2>Moderator (m/w) for Speed Dating events in Berlin</h2>
            <P>We are looking for permanent Moderators for speed-dating event in Berlin    </P>
            <h3>Requirements (what we are looking for):</h3>
            <ul>
                <li>Reliability, responsibility, punctuality</li>
                <li>Teamwork, ability to work independently</li>
                <li>Permanent resident in Berlin</li>
                <li>Available from 17h to 22h (weekends and some weekdays)</li>
            </ul>
            <h3>Benefits</h3>
            <ul>
                <li>15€ per moderated group (around 1.5h)</li>
                <li>Free coupons for friends / family</li>
            </ul>


            <p>If interested, send us an e-mail with the subject "Application as Speed Dating Moderator" to <a href="mailto:contact@hitchme.de">contact@hitchme.de</a>. Write to us at this e-mail just who you are and in which city or which cities would you like to moderate.
            </p>



        </div>
    </section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>


</body>
</html>
