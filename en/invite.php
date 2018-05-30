<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once ('head.php');
?>
<link rel="stylesheet" href="css/jPages.css">

<title>HitchMe &hearts; Search singles and invite them for a date</title>
<meta name="keywords" content="singles invite, hitchme invitation, meeting, meetup" />
<meta name="description" content="Search for singles in the city and join them for a meeting.">

</head>
<body>

<?php
require_once 'header.php';

?>
    <section id="portfolio">
        <div class="container">

            <div id='regbox' class="col-sm-6 col-md-offset-3">
                <h1>Browse and invite</h1>
                <p>Search singles in your city and invite them for meeting</p>

                <form name='newUser' id="searchForm">

                    <p>
                        <h2><?= $lang['I_AM'] ?>:</h2>
                        <select name="i_am" id="i_am" class="form-control">
                            <option value=""><?= lang('SELECT_GENDER'); ?></option>
                            <option value="male" ><?= lang('MAN'); ?></option>
                            <option value="female"><?= lang('WOMAN'); ?></option>
                        </select>
                    </p>
                    <p>
                        <h2><?= $lang['LOOKING_FOR'] ?>:</h2>
                        <select name="look_for" id="look_for" class="form-control">
                            <option value=""><?= lang('SELECT_GENDER'); ?></option>
                            <option value="male"><?= lang('MAN'); ?></option>
                            <option value="female"><?= lang('WOMAN'); ?></option>
                        </select>
                    </p>
                    <p>
                        <h2><?= $lang['AGE'] ?>:</h2>
                            <div class="form-group form-inline">
                                <label><?= $lang['BETWEEN'] ?> :</label>
                        <select name="age_from" id="age_from" class="form-control">
                            <?php
                            for ($i=20; $i<90; $i++){
                                echo ' <option value="'. $i .'">'. $i .'</option>';
                            }
                            ?>
                        </select>
                                <label>And :</label>
                            <select name="age_to" id="age_to" class="form-control">
                                <?php
                                for ($i=21; $i<90; $i++){
                                    echo ' <option value="'. $i .'">'. $i .'</option>';
                                }
                                ?>
                            </select>
                            </div>
                    </p>
                    <input type='submit' class="btn btn-primary btn-lg" value='<?= $lang['FIND'] ?>'/>
                </form>
            </div>
            <!-- item container -->
            <div class="col-lg-12 col-md-12 col-xs-12 thumb" id="result">
                <div id="loading" style="display: none; text-align: center;"><img src="images/loading.gif" alt="loading gif"> </div>
                <div class="holder"></div><!-- navigation holder -->
                <ul id="itemContainer">
                </ul>
                <div class="holder"></div><!-- navigation holder -->
            </div>
        </div>
    </section><!--/#portfolio-item-->
<?php
require_once 'footer.php';
?>
<script src="js/jPages.js"></script>
<script id="source" language="javascript" type="text/javascript">
    $(document).ajaxStart(function() {
        $( "#loading" ).show();
    });

    $("#searchForm").submit(function(event)
    {
        //Check if gender selected
        if(!$('#look_for' ).val()) {
            $('#look_for').css('border', 'solid 2px red');
            return false;
        }else{
            $('#look_for').removeAttr("style");
        }

        $('#itemContainer').empty();
        $('.holder').empty();

        $("#loading" ).show();
        $.ajax({
            type: 'POST',
            url: 'models/fetchUsers.php',       //the script to call to get data
            data: $("#searchForm").serialize(), //add the data to the form
            dataType: 'json',                   //data format
            success: function(data)             //on recieve of reply
            {
                console.log(data);
                if (!data){
                    $('#itemContainer').html('<i class="icon-heart-broken"> <?= $lang["NO_DATA"] ?>');
                }else{
                    $.each($(data), function(key, value) {
                        $('#itemContainer').append('<div class="col-lg-3 col-md-4 col-xs-6"><li><a href="<?= strtolower($lang['NAME']) ?>/view-profile.php?id='+value.user_id+'"><img src="images/profiles/'+value.user_id+'/'+value.profile_pic+'" alt="image"></a></li></div>');
                    });
                    $("div.holder").jPages({
                        containerID: "itemContainer"
                    });
                }
            },
            complete: function(){
                $('#loading').hide();
            },
            error: function()
            {
                $('#itemContainer').html('<i class="icon-heart-broken"> <?= $lang["NO_DATA"] ?>');
            }
        });
        return false;
    });

</script>

</body>
</html>
