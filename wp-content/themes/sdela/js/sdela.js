jQuery(document).ready(function($) {

/*
	$(".top-nav a").click(function(e) {
		e.preventDefault();
		$(".top-nav li").removeClass("top-nav-active");
		$(this).parent().addClass("top-nav-active");
	});
*/

	$(".select2").select2({
        allowClear: true,
        language: "ru",
		minimumResultsForSearch: Infinity
	});
    var $w2dcCategory = $('#w2dc-category');
	$(".select2-children").select2({
        allowClear: true,
        language: "ru",
        minimumResultsForSearch: Infinity,
        templateResult: function (category) {
            var currentSubcategories = $w2dcCategory.find('[value="'+$w2dcCategory.val()+'"]').data('children');
            if(!category.id || currentSubcategories.indexOf(category.id*1) < 0)
                return null;
            else
            	return category.text;
        }
    });

    // $(".srs-filter-date-from input").datepicker({
	// 	position: "bottom left",
	// 	minDate: new Date(),
	// 	startDate: new Date(),
	// 	autoClose: true
	// 	/*dateFormat: ' ',
	// 	timepicker: true,
	// 	classes: 'only-timepicker'*/
	// });
    //
	// $(".srs-filter-date-to input").datepicker({
	// 	position: "bottom right",
	// 	minDate: new Date(),
	// 	startDate: new Date(),
	// 	autoClose: true
	// 	/*dateFormat: ' ',
	// 	timepicker: true,
	// 	classes: 'only-timepicker'*/
	// });
    //
	// $(".srs-ft-from input").clockpicker({
	// 	align: "left",
	// 	autoclose: true,
	// 	twelvehour: false
	// });
    //
	// $(".srs-ft-to input").clockpicker({
	// 	align: "right",
	// 	autoclose: true,
	// 	twelvehour: false
	// });
    //
	// $(".srs-filter-checks label").click(function(e) {
	// 	e.preventDefault();
	// 	if ($(this).hasClass("srs-fc-chekced")) {
	// 		$(this).removeClass("srs-fc-chekced");
	// 		$(this).find("input").attr("checked", false);
	// 		$(this).find("input").checked = false;
	// 		$(this).find("input").prop("checked", false);
	// 	} else {
	// 		$(this).addClass("srs-fc-chekced");
	// 		$(this).find("input").attr("checked", "checked");
	// 		$(this).find("input").checked = true;
	// 		$(this).find("input").prop("checked", true);
	// 	};
	// });
    //
	// $(".srs-cb-o-more-prop-btn").click(function(e) {
	// 	e.preventDefault();
	// 	//$(".ds-options-container").removeClass("ds-options-container-active")
	// 	//$(this).stop().toggleClass("more-prop-btn-close-sr");
	// 	$(this).closest(".srs-card-body").find(".srs-cb-o-u-icons").stop().fadeIn(400);
	// 	var qQ = $(this).closest(".srs-card-container").find(".ds-options-container");
	// 	if (!qQ.hasClass("ds-options-container-active")) {
	// 		$(".ds-options-container").removeClass("ds-options-container-active")
	// 		$(this).closest(".srs-card-container").find(".ds-options-container").addClass("ds-options-container-active");
	// 	} else {
	// 		$(this).closest(".srs-card-container").find(".ds-options-container").removeClass("ds-options-container-active");
	// 	};
	// });
    //
	// $(".more-prop-btn").click(function(e) {
	// 	e.preventDefault();
	// 	$(this).stop().toggleClass("more-prop-btn-close");
	// 	$(".ds-options-container").addClass("ds-options-container-active");
	// });
    //
	// $(document).on("click", ".more-prop-btn.more-prop-btn-close", function(e) {
	// 	e.preventDefault();
	// 	$(".ds-options-container").removeClass("ds-options-container-active");
	// });
    //
	// $(".ds-oc-prop-rem").click(function(e) {
	// 	e.preventDefault();
	// 	$(this).parent().find(".ds-oc-more-prop-container").stop().fadeIn(400);
	// });
	// $(".ds-oc-more-prop-close-btn").click(function(e) {
	// 	e.preventDefault();
	// 	$(this).closest(".ds-oc-more-prop-container").stop().fadeOut(400);
	// });
    //
	// $(".ds-oc-show-all-u-btn").click(function(e) {
	// 	e.preventDefault();
	// 	$(".ds-oc-tl-users li").addClass("ds-oc-tl-user-active");
	// });
    //
	// var find_mouse=false;
    //
	// $(".more-prop-btn, .ds-options-container, .srs-cb-o-more-prop-btn").hover(function(){
	// 	find_mouse=true;
	// }, function(){
	// 	find_mouse=false;
	// });
    //
	// $("body, html").click(function(e) {
	// 	if(!find_mouse) {
	// 		$(".ds-options-container").stop().removeClass("ds-options-container-active");
	// 		$(".more-prop-btn").addClass("more-prop-btn-close");
	// 	};
	// });
    //
	// $(".top-nav-btn").click(function(e) {
	// 	e.preventDefault();
	// 	$(".top-nav ul").stop().slideToggle(400);
	// });
    //
	// $(".close-btn").click(function(e) {
	// 	e.preventDefault();
	// 	$(".more-prop-btn").removeClass("more-prop-btn-close");
	// 	$(".more-prop-btn").addClass("more-prop-btn-close");
	// 	$(".ds-options-container").stop().removeClass("ds-options-container-active");
	// });

	function gmap_load () {
		if ($(".g-map").length) {
			/*var script = document.createElement('script');++++++++
			script.id = 'api-maps-google';
			script.type = 'text/javascript';
			script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCwTn0T2CZo4xYCz0gNocEISyQxkTAW2B8&callback=initMap';*/
			/*script.src = 'https://maps.googleapis.com/maps/api/js?v=3.13&' +
				'callback=initMap';*/
				/*'https://maps.googleapis.com/maps/api/js?key=AIzaSyCwTn0T2CZo4xYCz0gNocEISyQxkTAW2B8&callback=initMap'*/
			//document.body.appendChild(script);
			initMap();
		};
	};gmap_load();

	function initMap () {
		var myLatLng = {lat: 42.2839113, lng: 18.8377231};

		var map = new google.maps.Map(document.getElementById('map'), {
			center: myLatLng,
			scrollwheel: false,
			zoom: 16
		});
		var marker = new google.maps.Marker({
			map: map,
			position: myLatLng,
		});

		var mapContent = "Черногория, Будва, Лази 24/1";

		var infoWindow = new google.maps.InfoWindow({
			content: mapContent
		});

		google.maps.event.addListener(marker, 'click', function() {
			infoWindow.open(map, marker);
		});
	};
	
});

// $(window).load(function() {
// 	//$(".loader").fadeOut(1000000);
// 	$(".wrapper").addClass("loader-fade").fadeOut(400);
// });