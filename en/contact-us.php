<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once ('head.php');
?>
<title>HitchMe &hearts; Contact us</title>
<meta name="keywords" content="Hitchme contact" />
<meta name="description" content="'Contact us and keep in touch with HitchMe team.">

</head><!--/head-->
<body>
<?php
require_once 'header.php';
?>
    <section id="contact-info">
        <div class="center">                
            <!--<h2>How to Reach Us?</h2>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
        </div>
        <div class="gmap-area">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <div class="gmap">
                            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=JoomShaper,+Dhaka,+Dhaka+Division,+Bangladesh&amp;aq=0&amp;oq=joomshaper&amp;sll=37.0625,-95.677068&amp;sspn=42.766543,80.332031&amp;ie=UTF8&amp;hq=JoomShaper,&amp;hnear=Dhaka,+Dhaka+Division,+Bangladesh&amp;ll=23.73854,90.385504&amp;spn=0.001515,0.002452&amp;t=m&amp;z=14&amp;iwloc=A&amp;cid=1073661719450182870&amp;output=embed"></iframe>
                        </div>
                    </div>

                    <div class="col-sm-7 map-content">
                        <ul class="row">
                            <li class="col-sm-6">
                                <address>
                                    <h5>Head Office</h5>
                                    <p>1537 Flint Street <br>
                                    Tumon, MP 96911</p>
                                    <p>Phone:670-898-2847 <br>
                                    Email Address:info@domain.com</p>
                                </address>

                                <address>
                                    <h5>Zonal Office</h5>
                                    <p>1537 Flint Street <br>
                                    Tumon, MP 96911</p>                                
                                    <p>Phone:670-898-2847 <br>
                                    Email Address:info@domain.com</p>
                                </address>
                            </li>


                            <li class="col-sm-6">
                                <address>
                                    <h5>Zone#2 Office</h5>
                                    <p>1537 Flint Street <br>
                                    Tumon, MP 96911</p>
                                    <p>Phone:670-898-2847 <br>
                                    Email Address:info@domain.com</p>
                                </address>

                                <address>
                                    <h5>Zone#3 Office</h5>
                                    <p>1537 Flint Street <br>
                                    Tumon, MP 96911</p>
                                    <p>Phone:670-898-2847 <br>
                                    Email Address:info@domain.com</p>
                                </address>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>-->
        </div>
    </section>  <!--/gmap_area -->

    <section id="contact-page">
        <div class="container">
            <h1>Get in touch with us</h1>
            <div class="center">        
                <h2><?= lang('DROP_YOUR_MESSAGE') ?></h2>
            </div>
            <div class="row contact-wrap">
                <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="sendemail.php">
                    <div id="form_status" style="padding: 0 15px 0 15px"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label><?= lang('FULL_NAME') ?> *</label>
                            <input id="name" type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><?= lang('EMAIL') ?> *</label>
                            <input id="email" type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><?= lang('PHONE') ?></label>
                            <input type="number" name="phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><?= lang('ADDRESS') ?></label>
                            <input type="text" name="address" class="form-control">
                        </div>                        
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Subject *</label>
                            <input id="subject"  type="text" name="subject" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Message *</label>
                            <textarea id="message" name="message" id="message"  class="form-control" rows="8"></textarea>
                        </div>                        
                        <div class="form-group">
                            <button  type="submit" name="submit" class="btn btn-primary btn-lg"><?= lang('SUBMIT_MESSAGE') ?></button>
                        </div>
                    </div>
                </form> 
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#contact-page-->

<?php
require_once 'footer.php';
?>
<script src="js/formValidator.js"></script>
</body>
</html>