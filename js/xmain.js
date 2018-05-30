jQuery(function($) {'use strict',

	//#main-slider
	$(function(){
		$('#main-slider.carousel').carousel({
			interval: 8000
		});
	});

	//profile form validation
	$("#submit-profile").click(function(){

		var name = $.trim($('#fname').val());
		var name = $.trim($('#lname').val());


		// Check if empty of not
		if (name  === '') {
			alert('First name is empty.');
			return false;
		}
	});


	submit-profile
	// accordian
	$('.accordion-toggle').on('click', function(){
		$(this).closest('.panel-group').children().each(function(){
		$(this).find('>.panel-heading').removeClass('active');
		 });

	 	$(this).closest('.panel-heading').toggleClass('active');
	});

	//Initiat WOW JS
	new WOW().init();

	// portfolio filter
	$(window).load(function(){'use strict';
		var $portfolio_selectors = $('.portfolio-filter >li>a');
		var $portfolio = $('.portfolio-items');
		$portfolio.isotope({
			itemSelector : '.portfolio-item',
			layoutMode : 'fitRows'
		});
		
		$portfolio_selectors.on('click', function(){
			$portfolio_selectors.removeClass('active');
			$(this).addClass('active');
			var selector = $(this).attr('data-filter');
			$portfolio.isotope({ filter: selector });
			return false;
		});
	});

	// Contact form
	// Contact form
	var form = $('#main-contact-form');
	form.submit(function(event){
		event.preventDefault();
		var form_status = $('<div class="form_status"></div>');
		$.ajax({
			type: "POST",
			url: $(this).attr('action'),
			data: form.serialize(),

			beforeSend: function(){
				form.prepend( form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Email is sending...</p>').fadeIn() );
			}
		}).done(function(data){
			form_status.html('<p class="text-success">' + data.message + '</p>').delay(3000).fadeOut();
		});
	});

	
	//goto top
	$('.gototop').click(function(event) {
		event.preventDefault();
		$('html, body').animate({
			scrollTop: $("body").offset().top
		}, 500);
	});	

	//Pretty Photo
	$("a[rel^='prettyPhoto']").prettyPhoto({
		social_tools: false
	});	
});

//for steps form
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
//end steps form script