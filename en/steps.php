<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
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

            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step">
                        <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                        <p>Step 1</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                        <p>Step 2</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                        <p>Step 3</p>
                    </div>
                    <div class="stepwizard-step">
                        <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                        <p>Step 4</p>
                    </div>
                </div>
            </div>
            <form role="form">
                <div class="row setup-content" id="step-1">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3> Step 1</h3>
                            <div class="form-group">
                                <label class="control-label">First Name</label>
                                <input  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter First Name"  />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Last Name</label>
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Last Name" />
                            </div>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-2">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3> Step 2</h3>
                            <div class="form-group">
                                <label class="control-label">Company Name</label>
                                <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Name" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Company Address</label>
                                <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Address"  />
                            </div>
                            <button class="btn btn-default prevBtn btn-lg pull-left" type="button" >Prev</button>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-3">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3> Step 3</h3>
                            <div class="form-group">
                                <label class="control-label">Skills</label>
                                <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter skill or skills" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Comment</label>
                                <textarea class="form-control" placeholder="Enter Comment" ></textarea>
                            </div>
                            <button class="btn btn-default prevBtn btn-lg pull-left" type="button" >Prev</button>
                            <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                        </div>
                    </div>
                </div>
                <div class="row setup-content" id="step-4">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3> Step 4</h3>
                            <button class="btn btn-default prevBtn btn-lg pull-left" type="button" >Prev</button>
                            <button class="btn btn-success btn-lg pull-right" type="submit">Finish!</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </section><!--/#portfolio-item-->

<?php
require_once 'footer.php';
?>
<script language="JavaScript">
$(document).ready(function () {

var navListItems = $('div.setup-panel div a'),
allWells = $('.setup-content'),
allNextBtn = $('.nextBtn'),
allPrevBtn = $('.prevBtn');

allWells.hide();

navListItems.click(function (e) {
e.preventDefault();
var $target = $($(this).attr('href')),
$item = $(this);

if (!$item.hasClass('disabled')) {
navListItems.removeClass('btn-primary').addClass('btn-default');
$item.addClass('btn-primary');
allWells.hide();
$target.show();
$target.find('input:eq(0)').focus();
}
});

allNextBtn.click(function(){
var curStep = $(this).closest(".setup-content"),
curStepBtn = curStep.attr("id"),
nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
curInputs = curStep.find("input[type='text'],input[type='url']"),
isValid = true;

$(".form-group").removeClass("has-error");
for(var i=0; i<curInputs.length; i++){
if (!curInputs[i].validity.valid){
isValid = false;
$(curInputs[i]).closest(".form-group").addClass("has-error");
}
}

if (isValid)
nextStepWizard.removeAttr('disabled').trigger('click');
});

allPrevBtn.click(function(){
var curStep = $(this).closest(".setup-content"),
curStepBtn = curStep.attr("id"),
prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

$(".form-group").removeClass("has-error");
prevStepWizard.removeAttr('disabled').trigger('click');
});

$('div.setup-panel div a.btn-primary').trigger('click');
});
</script>
</body>
</html>
