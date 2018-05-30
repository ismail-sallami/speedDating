<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Forms posted
$user_id = $loggedInUser->user_id;
define('IMAGEPATH', '../images/profiles/'.$user_id.'/');
if(!empty($_POST))
{

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $bdate =    date('Y-m-d', strtotime(str_replace('-', '/', $_POST['bdate'])));
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $eyes = $_POST['eyes'];
    $hair = $_POST['hair'];
    $height = $_POST['height'];
    $marital = $_POST['marital'];
    $kids  = $_POST['kids'];
    $smoking  = $_POST['smoking'];
    $drinking  = $_POST['drinking'];
    $hobbies  = $_POST['hobbies'];
    $books  = $_POST['books'];
    $music = $_POST['music'];
    $movies  = $_POST['movies'];
    $aboutme  = $_POST['aboutme'];
    $profile_pic  = $_POST['profile_pic'];

    $delete_pic = $_POST['delete_pic'];
    //Can'T delete profile pic
    if (isset($delete_pic)){
        foreach ($delete_pic as $pic){
            if ($profile_pic == $pic){
                $errors[] = lang("DELETE_PROFILE_PIC");
            }else{
                unlink(IMAGEPATH.$pic);
            }
        }
    }
    //Set the first image as default profile pic
    $sImage = uploadImageFile($user_id);
    if (!isset($profile_pic)){
        $profile_pic = basename($sImage);
    }

    if (updateProfile($user_id, $fname, $lname, $bdate, $phone, $gender, $eyes, $hair, $height, $marital, $kids, $smoking, $drinking, $hobbies, $books, $music, $movies, $aboutme, $profile_pic )){
        $successes[] = lang("PROFILE_UPDATED");
    }
    else {
        $errors[] = lang("SQL_ERROR");
    }

}

$userProfile = fetchUserProfile($loggedInUser->user_id);
require_once ('head.php');
?>
    <!-- add styles -->
    <link href="css/crop.css" rel="stylesheet" type="text/css" />
    <link href="css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />


    <!-- radio and checkbox styles -->
    <link href="css/input_radio.css" rel="stylesheet">

</head>
<body>

<?php
require_once 'header.php';
?>
    <section id="portfolio">
        <div class="container">


            <form id="fileupload" action='<?= $_SERVER['PHP_SELF'] ?>' method="POST" enctype="multipart/form-data"  onsubmit="return checkForm()" data-ng-app="demo" data-ng-controller="DemoFileUploadController" data-file-upload="options" data-ng-class="{'fileupload-processing': processing() || loadingFiles}">
                <div class="col-sm-8 col-md-offset-2 ww ">
                    <div id="submit_errors"></div>
                    <?php
                    echo resultBlock($errors,$successes);
                    ?>
                    <div class="tab-wrap">
                        <div class="media">
                            <div class="parrent pull-left">
                                <ul class="nav nav-tabs nav-stacked">
                                    <li class="active"><a href="#tab1" data-toggle="tab" class="analistic-01"><?= lang('BASIC_INFO'); ?></a></li>
                                    <li class=""><a href="#tab2" data-toggle="tab" class="analistic-02"><?= lang('PUBLIC_PROFILE'); ?></a></li>
                                    <li class=""><a href="#tab3" data-toggle="tab" class="tehnical"><?= lang('INTERESTS'); ?></a></li>
                                    <li class=""><a href="#tab4" data-toggle="tab" class="tehnical"><?= lang('FOTOS'); ?></a></li>
                                </ul>
                            </div>

                            <div class="parrent media-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="tab1">
                                        <div class="media">

                                            <div class="media-body">
                                                <label><?= lang('F_NAME'); ?>:</label>
                                                <input type='text'id="fname" class="form-control" name='fname' value="<?= $userProfile ? $userProfile['fname'] : '' ?>"/>
                                                <label><?= lang('L_NAME'); ?>:</label>
                                                <input type='text' id="lname" class="form-control"  name='lname' value="<?= $userProfile ? $userProfile['lname'] : '' ?>" />
                                                <label><?= lang('BIRTH'); ?> **:</label>
                                                <!--<input type='date' class="form-control" id='bdate' name='bdate'  value="<?= $userProfile ? $userProfile['bdate'] : '' ?>"/>-->
                                                 <input type='text' id='bdate' name='bdate' class="form-control" value="<?= $userProfile ? date("m/d/Y", strtotime( $userProfile['bdate'])): '' ?>"/>
                                                <label><?= lang('PHONE'); ?> **:</label>
                                                <input type='text' id="phone" class="form-control"  name='phone' value="<?= $userProfile ? $userProfile['phone'] : '' ?>"/>
                                                <label><?= lang('GENDER'); ?>:</label>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value=""><?= lang('SELECT_GENDER'); ?></option>
                                                    <option value="male" <?= $userProfile['gender']=='male' ? 'selected' : '' ?> ><?= lang('MAN'); ?></option>
                                                    <option value="female" <?= $userProfile['gender']=='female' ? 'selected' : '' ?>><?= lang('WOMAN'); ?></option>
                                                </select>
                                                <hr>
                                                <div id="notPublic">(**) : <?= lang('NOT_PUBLIC'); ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade " id="tab2">
                                        <div class="media">
                                            <div class="media-body">
                                                <label><?= lang('EYES'); ?>:</label>
                                                <select name="eyes" class="form-control">
                                                    <option value="Blue" <?= $userProfile['eyes']=='Blue' ? 'selected' : '' ?>><?= lang('BLUE'); ?></option>
                                                    <option value="Brown" <?= $userProfile['eyes']=='Brown' ? 'selected' : '' ?>><?= lang('BROWN'); ?></option>
                                                    <option value="Green" <?= $userProfile['eyes']=='Green' ? 'selected' : '' ?>><?= lang('GREEN'); ?></option>
                                                    <option value="Black" <?= $userProfile['eyes']=='Black' ? 'selected' : '' ?>><?= lang('BLACK'); ?></option>
                                                    <option value="Gray" <?= $userProfile['eyes']=='Gray' ? 'selected' : '' ?>><?= lang('GRAY'); ?></option>
                                                    <option value="other" <?= $userProfile['eyes']=='other' ? 'selected' : '' ?>><?= lang('OTHER'); ?></option>
                                                </select>
                                                <label><?= lang('HAIR'); ?>:</label>
                                                <select name="hair" class="form-control">
                                                    <option value="Blond" <?= $userProfile['hair']=='Blond' ? 'selected' : '' ?> ><?= lang('BLOND'); ?></option>
                                                    <option value="Brown" <?= $userProfile['hair']=='Brown' ? 'selected' : '' ?>><?= lang('BROWN'); ?></option>
                                                    <option value="White" <?= $userProfile['hair']=='White' ? 'selected' : '' ?>><?= lang('WHITE'); ?></option>
                                                    <option value="Gray" <?= $userProfile['hair']=='Gray' ? 'selected' : '' ?>><?= lang('GRAY'); ?></option>
                                                    <option value="Black" <?= $userProfile['hair']=='Black' ? 'selected' : '' ?>><?= lang('BLACK'); ?></option>
                                                    <option value="Red" <?= $userProfile['hair']=='Red' ? 'selected' : '' ?>><?= lang('RED'); ?></option>
                                                    <option value="other" <?= $userProfile['hair']=='other' ? 'selected' : '' ?>><?= lang('OTHER'); ?></option>
                                                </select>

                                                <label><?= lang('HEIGHT'); ?>:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="height" id="hright" value="<?= $userProfile['height'] ? $userProfile['height'] : '00' ?>" >
                                                    <div class="input-group-addon">cm</div>
                                                </div>

                                                <label><?= lang('MARITAL'); ?>:</label>
                                                <select name="marital" class="form-control">
                                                    <option value="Single" <?= $userProfile['marital']=='Single' ? 'selected' : '' ?>><?= lang('SINGLE'); ?></option>
                                                    <option value="Seperated" <?= $userProfile['marital']=='Seperated' ? 'selected' : '' ?>><?= lang('SEPERATED'); ?></option>
                                                    <option value="Divorced" <?= $userProfile['marital']=='Divorced' ? 'selected' : '' ?>><?= lang('DIVORCED'); ?></option>
                                                    <option value="Widowed" <?= $userProfile['marital']=='Widowed' ? 'selected' : '' ?>><?= lang('WIDOWED'); ?></option>
                                                </select>
                                                <label><?= lang('KIDS'); ?>:</label>
                                                <select name="kids" class="form-control">
                                                    <option value="No"  <?= $userProfile['kids']=='No' ? 'selected' : '' ?>><?= lang('NO'); ?></option>
                                                    <option value="1" <?= $userProfile['kids']=='1' ? 'selected' : '' ?>>1</option>
                                                    <option value="2" <?= $userProfile['kids']=='2' ? 'selected' : '' ?>>2</option>
                                                    <option value=">2" <?= $userProfile['kids']=='>2' ? 'selected' : '' ?>>>2</option>
                                                </select>
                                                <label><?= lang('SMOKING'); ?>:</label>
                                                <select name="smoking" class="form-control">
                                                    <option value="No" <?= $userProfile['smoking']=='No' ? 'selected' : '' ?>><?= lang('NO'); ?></option>
                                                    <option value="Occasionally" <?= $userProfile['smoking']=='Occasionally' ? 'selected' : '' ?>><?= lang('SOCIALLY'); ?></option>
                                                    <option value="Yes" <?= $userProfile['smoking']=='Yes' ? 'selected' : '' ?>><?= lang('YES'); ?></option>
                                                </select>

                                                <label><?= lang('DRINKING'); ?>:</label>
                                                <select name="drinking" class="form-control">
                                                    <option value="No" <?= $userProfile['drinking']=='No' ? 'selected' : '' ?>><?= lang('NO'); ?></option>
                                                    <option value="Occasionally" <?= $userProfile['drinking']=='Occasionally' ? 'selected' : '' ?>><?= lang('SOCIALLY'); ?></option>
                                                    <option value="Yes" <?= $userProfile['drinking']=='Yes' ? 'selected' : '' ?>><?= lang('YES'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tab3">
                                        <label for="comment"><?= lang('HOBBIES'); ?>:</label>
                                        <textarea maxlength="500" class="form-control" name="hobbies" rows="5" id="comment"><?= $userProfile ? $userProfile['hobbies'] : '' ?></textarea>
                                        <label for="comment"><?= lang('BOOKS'); ?>:</label>
                                        <textarea  maxlength="500" class="form-control" name="books" rows="5" id="comment"><?= $userProfile ? $userProfile['books'] : '' ?></textarea>
                                        <label for="comment"><?= lang('MUSIC'); ?>:</label>
                                        <textarea  maxlength="500" class="form-control" name="music" rows="5" id="comment"><?= $userProfile ? $userProfile['music'] : '' ?></textarea>
                                        <label for="comment"><?= lang('MOVIES'); ?>:</label>
                                        <textarea  maxlength="500" class="form-control" rows="5" name="movies" id="comment"><?= $userProfile ? $userProfile['movies'] : '' ?></textarea>
                                        <label for="comment"><?= lang('MORE_ABOUT_ME'); ?>:</label>
                                        <textarea  maxlength="2000" class="form-control" name="aboutme" rows="5" id="comment"><?= $userProfile ? $userProfile['aboutme'] : '' ?></textarea>
                                    </div>
                                    <div class="tab-pane fade" id="tab4">
                                        <?php

                                        foreach(glob(IMAGEPATH.'*') as $filename){
                                            $checked = '';
                                            if (basename($filename) == $userProfile['profile_pic']){
                                                $checked = ' checked';
                                            }
                                            echo '<img src="../images/profiles/'.$user_id.'/'.basename($filename) . '" width="150">';
                                            echo ' <div class="btn-group" data-toggle="buttons">
                                                        <label class="btn">
                                                            <input type="radio"  id="profile_pic" name="profile_pic" value="'.basename($filename).'"'.$checked.' ><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-check-circle-o fa-2x"></i><span> '. lang('PROFILE_PIC').'</span>
                                                        </label><br>
                                                        <label class="btn">
                                                          <input type="checkbox"  id="'.basename($filename).'" name="delete_pic[]" value="'.basename($filename).'" onclick="return checkBeforeDelete(this)"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i> <span> '. lang('DELETE_PIC').'</span>
                                                        </label>
                                                    </div>
                                                        <br><br>
                                                  ';
                                        }
                                        ?>
                                            <!-- upload form -->
                                                <!-- hidden crop params -->
                                                <input type="hidden" id="x1" name="x1" />
                                                <input type="hidden" id="y1" name="y1" />
                                                <input type="hidden" id="x2" name="x2" />
                                                <input type="hidden" id="y2" name="y2" />

                                                <h2><?= lang('IMAGE_STEP_1') ?></h2>
                                                <label class="btn btn-default btn-file">
                                                    <?= lang('BROWSE') ?><input type="file" name="image_file" id="image_file"  style="display: none;" onchange="fileSelectHandler()" />
                                                </label>

                                                <div class="error"></div>

                                                <div class="step2">
                                                    <h2><?= lang('IMAGE_STEP_2') ?></h2>
                                                    <img id="preview"/>
                                                    <input type="hidden" id="filesize" name="filesize" />
                                                    <input type="hidden" id="filetype" name="filetype" />
                                                    <input type="hidden" id="filedim" name="filedim" />
                                                    <input type="hidden" id="w" name="w" />
                                                    <input type="hidden" id="h" name="h" />
                                                    <input type="submit"  class="btn btn-default" value="<?= lang('UPLOAD') ?>" />
                                                </div>
                                    </div>
                                </div> <!--/.tab-content-->
                            </div> <!--/.media-body-->
                        </div> <!--/.media-->
                    </div><!--/.tab-wrap-->
                    <div class="btn-toolbar pull-right" role="group" aria-label="Basic example">
                        <a href="<?= strtolower($lang['NAME']) ?>/profile.php" class=" btn btn-primary btn-lg "><?= lang('VIEW_PROFILE') ?></a>
                        <input type="submit" class="submit btn btn-primary btn-lg" value="<?= lang('SUBMIT') ?>">
                    </div>
                </div><!--/.col-sm-6-->
            </form>
        </div>
    </section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>
<script src="js/jquery.Jcrop.min.js"></script>
<script type="text/javascript">// script to pass the error message to crop.js
    var error_crop = "<?= lang('ERROR_CROP') ?>";
    var error_valid_image = "<?= lang('ERROR_VALID_IMAGE') ?>";
    var error_size = "<?= lang('ERROR_SIZE') ?>";
</script>
<script  type="text/javascript" src="js/crop.js"></script>
<script  type="text/javascript" src="js/moment-with-locales.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>

<script>
    jQuery(function($){
        $("#bdate").mask("99/99/9999",{placeholder:"DD/MM/YYYY"});
    });


    function checkBeforeDelete(me){
        alert(me.id);
    }

    $('form').submit(function () {
        var errors ="";
        // Get the Login Name value and trim it
        var phone = $.trim($('#phone').val());
        var fname = $.trim($('#fname').val());
        var lname = $.trim($('#lname').val());
        var bdate = $.trim($('#bdate').val());
        var gender = $('#gender').val();

        // Check if empty of not
        if (phone === '') {
         errors = errors + "<p><?= lang('PHONE_EMPTY'); ?></p>";
         }
         if (fname === '') {
         errors = errors + "<p><?= lang('FIRST_NAME_EMPTY'); ?></p>";
         }
         if (lname === '') {
         errors = errors + "<p><?= lang('LAST_NAME_EMPTY'); ?></p>";
         }
         if (bdate === '') {
         errors = errors + "<p><?= lang('BDATE_EMPTY'); ?></p>";
         }
         if (gender === '') {
         errors = errors + "<p><?= lang('GENDER_EMPTY'); ?></p>";
         }

        //if no picture
        if (!document.getElementById('profile_pic')){
            if ($('#image_file').get(0).files.length === 0) {
                errors = errors +"<p><?= lang('PICS_EMPTY'); ?></p>";
            }
        }

        /*if(!$("input:radio[name='profile_pic']").is(":checked")) {
            errors = errors +"<p><?= lang('PROFILE_PIC_EMPTY'); ?></p>";
        }*/
        if (errors!=""){
            $( "#result" ).hide(); //hide any alert result div
            $( "#submit_errors" ).addClass( "alert alert-danger" );
            $("#submit_errors").html(errors);
            return false;
        }

    });
</script>

</body>
</html>
