/**
 * Stand alone polyfill allow only numbers on input of type number.
 *
 * While input filtering is already supported by default by some browsers, maximum length has not been implemented by
 * any. This script will solve both issue and make sure that only digits can be entered in input elements of type
 * number. If the optional attribute `max` is set, it will calculate it's length and mimic the `maxlength` behavior on
 * input of type text.
 *
 * Supports:
 *
 *  - Browsers: IE8+ and any other browsers.
 *
 * Limitations:
 *
 * - Must use an addEventListener polyfill (e.g. https://github.com/nbouvrette/eventListenerPolyfill) for IE8 support.
 * - Must use HTML5shiv (https://github.com/afarkas/html5shiv) for IE8 support.
 *
 * Usage:
 *
 * <input type="number" id="number" min="0" max="100">
 * <script>
 *     var number = document.getElementById("number");
 *     inputTypeNumberPolyfill.polyfillElement(number);
 * </script>
 */
window.inputTypeNumberPolyfill = {

    /**
     * Does the clipboard contain a numerical value?
     *
     * @private
     *
     * @param {Event} event - The paste event triggering this method.
     */
    clipboardIsNumeric: function (event) {
        event = (event) ? event : window.event;
        var clipboardData = (event.clipboardData) ? event.clipboardData.getData('Text') : window.clipboardData.getData('Text');
        var isNumber = /^\d+$/.test(clipboardData);
        return (isNumber);
    },

    /**
     * Is the clipboard data bigger than the element's maximum length?
     *
     * @private
     *
     * @param {Event} event - The paste event triggering this method.
     * @param {HTMLElement|HTMLInputElement} element - The HTML element.
     */
    eventIsBlockedByMaxWhenPasting: function (event, element) {
        var maximumValueLength = this.getMaxValueLength(element);
        if (maximumValueLength) {
            event = (event) ? event : window.event;
            var clipboardData = (event.clipboardData) ? event.clipboardData.getData('Text') : window.clipboardData.getData('Text');
            var clipboardDataLength = (typeof clipboardData == 'undefined') ? 0 : clipboardData.length;
            var selectedTextLength = this.getSelectedTextLength(event, element);
            return ((element.value.length + clipboardDataLength - selectedTextLength) > maximumValueLength);
        }
        return false;
    },

    /**
     * Get the selected text length.
     *
     * @private
     *
     * There are multiple bugs linked to selection in all major current browsers. This method works around the
     * documented problems mentioned below:
     *
     * - Chrome: http://stackoverflow.com/questions/21177489/selectionstart-selectionend-on-input-type-number-no-longer-allowed-in-chrome
     * - Firefox: https://bugzilla.mozilla.org/show_bug.cgi?id=85686
     *
     * @param {Event|KeyboardEvent} event - The event triggering this method.
     * @param {HTMLElement|HTMLInputElement} element - The HTML element.
     *
     * @returns {Number} Returns the selected text length or 0 when unable to get it.
     */
    getSelectedTextLength: function (event, element) {
        var selectionLength = 0;

        try {
            // Used by Firefox and modern IE (using a Chrome workaround).
            selectionLength = (element.selectionEnd - element.selectionStart);
            selectionLength = (typeof selectionLength == 'number' && !isNaN(selectionLength)) ? selectionLength : 0;
        } catch (error) {
        }

        if (!selectionLength) {
            if (window.getSelection) {
                // Used by Chrome.
                var selection = window.getSelection();
                selectionLength = (selection == 'undefined') ? 0 : selection.toString().length;
            } else if (document.selection && document.selection.type != 'None') {
                // Used IE8.
                var textRange = document.selection.createRange();
                selectionLength = textRange.text.length;
            }
        }

        return selectionLength;
    },

    /**
     * Is the next typed character blocked by element's maximum length?
     *
     * @private
     *
     * @param {KeyboardEvent} event - The Keyboard event triggering this method.
     * @param {HTMLElement|HTMLInputElement} element - The HTML element.
     */
    eventIsBlockedByMaxWhenTyping: function (event, element) {
        var maximumValueLength = this.getMaxValueLength(element);
        if (maximumValueLength) {
            event = (event) ? event : window.event;
            var selectedTextLength = this.getSelectedTextLength(event, element);
            var characterLength = this.getCharCodeLength(event);
            return ((element.value.length - selectedTextLength + characterLength) > maximumValueLength);
        }
        return false;
    },

    /**
     * Does the element have a max attribute set? And if it is valid, what is its length.
     *
     * @private
     *
     * @param {HTMLElement|HTMLInputElement} element - The HTML element.
     */
    getMaxValueLength: function (element) {
        var maximumValue = element.getAttribute('max');
        if (!maximumValue || !/^\d+$/.test(maximumValue)) {
            return 0;
        } else {
            return maximumValue.length;
        }
    },

    /**
     * Is the event's character a digit?
     *
     * @private
     *
     * @param {KeyboardEvent} event - The Keyboard event triggering this method.
     */
    eventKeyIsDigit: function (event) {
        event = (event) ? event : window.event;
        var keyCode = (event.which) ? event.which : event.keyCode;
        return (this.codeIsADigit(keyCode) || this.charCodeIsAllowed(event));
    },

    /**
     * Is a given keyboard event code (charCode or keyCode) a digit?
     *
     * @private
     *
     * @param {Number|Object} code - The Keyboard event key code.
     */
    codeIsADigit: function (code) {
        var stringCode = String.fromCharCode(code);
        return /^\d$/.test(stringCode);
    },

    /**
     * Is the charCode of this event allowed?
     *
     * @private
     *
     * Some browsers already filter keys for input of type number which means some `onkeypress` event will never get
     * triggered. For other browsers (e.g. Firefox) we need to filter which keys are pressed to only allow digits and
     * any other non typeable keys. There are 3 types of keys we want to let go through:
     *
     * - Digits.
     * - Non typeable characters (moving arrows, backspace, del, tab, etc.).
     * - Key combinations (alt, ctrl, shift, etc) - used for copy paste and other functionalities.
     *
     * @param {KeyboardEvent} event - The Keyboard event triggering this method.
     */
    charCodeIsAllowed: function (event) {
        event = (event) ? event : window.event;
        var charCode = event.charCode;
        var keyCode = (event.which) ? event.which : event.keyCode;
        charCode = (typeof charCode === 'undefined') ? keyCode : charCode; // IE8 fallback.

        if (charCode === 0) {
            // Non typeable characters are allowed.
            return true;
        } else if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
            // All combinations are allowed.
            return true
        } else if (!this.codeIsADigit(charCode)) {
            // Any other character that is not a digit will be blocked.
            return false;
        }

        // The only characters left are numeric, so we let them through.
        return true;
    },

    /**
     * Get the character code length.
     *
     * @private
     *
     * @param {KeyboardEvent} event - The Keyboard event triggering this method.
     */
    getCharCodeLength: function (event) {
        event = (event) ? event : window.event;
        var charCode = event.charCode;
        var keyCode = (event.which) ? event.which : event.keyCode;
        charCode = (typeof charCode === 'undefined') ? keyCode : charCode; // IE8 fallback.

        if (charCode === 0) {
            // Non typeable characters have no length.
            return 0;
        } else if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
            // All combinations have no length.
            return 0
        } else if (!this.codeIsADigit(charCode)) {
            // All non-allowed characters have 0 length (because they will be blocked).
            return 0;
        }

        return 1; // By default a character has a length of 1.
    },

    /**
     * Polyfill a given element.
     *
     * @param {HTMLElement|HTMLInputElement} element - The HTML element.
     */
    polyfillElement: function (element) {

        element.addEventListener('keypress', function (event) {
            if (!inputTypeNumberPolyfill.eventKeyIsDigit(event) ||
                inputTypeNumberPolyfill.eventIsBlockedByMaxWhenTyping(event, element)) {
                event.preventDefault();
            }
        });

        element.addEventListener('paste', function (event) {
            if (!inputTypeNumberPolyfill.clipboardIsNumeric(event) ||
                inputTypeNumberPolyfill.eventIsBlockedByMaxWhenPasting(event, element)) {
                event.preventDefault();
            }
        });

    }
};


jQuery(document).ready(function($) {

/*
	$(".top-nav a").click(function(e) {
		e.preventDefault();
		$(".top-nav li").removeClass("top-nav-active");
		$(this).parent().addClass("top-nav-active");
	});
*/
    var $titleInput = $('input[name="post_title"]');
    var $charCount = $('<span class="char-limit" /></span>');
	var countChars = function(){
        var maxLength = $titleInput.attr('maxlength');
        var len = $titleInput.val().length;
        if (len > 0)
        	$charCount.addClass('active');
        else
        	$charCount.removeClass('active');
        if(len > maxLength)
            return false;
        $charCount.text(len === 0 ? maxLength + ' знаков' : (maxLength-len)+' / '+maxLength);
    };
	countChars();
    $titleInput.keyup(countChars).parent().append($charCount);

    $('.w2dc-field-input-price').each(function () {
        inputTypeNumberPolyfill.polyfillElement(this);
    });

    $(".w2dc-field-input-select").select2({
        allowClear: true,
        language: "ru",
		minimumResultsForSearch: Infinity
	});
    var $w2dcCategory = $('#w2dc-category');
	$("#w2dc-field-input-subcategory").select2({
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

	var $fromDate = $(".srs-filter-date-from input[type='hidden']");
    $(".srs-filter-date-from input[type='text']").datepicker({
        position: "bottom left",
        minDate: new Date(),
        startDate: new Date($fromDate.val()?$fromDate.val():null),
        autoClose: true,
		onSelect: function(dateStr, dateObj) {
        	$fromDate.val(dateObj.getTime()/1000);
            $(".srs-filter-date-to input[type='text']")
				.data('datepicker').update('minDate', dateObj);
		}
    });

    var $toDate = $(".srs-filter-date-to input[type='hidden']");
    $(".srs-filter-date-to input[type='text']").datepicker({
        position: "bottom right",
        minDate: new Date(),
        startDate: new Date($toDate.val()?$toDate.val():null),
        autoClose: true,
        onSelect: function(dateStr, dateObj) {
            $toDate.val(dateObj.getTime()/1000)
        }
    });

	$(".srs-ft-from input").clockpicker({
	 	align: "left",
	 	autoclose: true,
	 	twelvehour: false,
		default: 'now',
        afterDone: function (e, a) {
			console.log(e);
			console.log(a)
        }
	});

	$(".srs-ft-to input").clockpicker({
	 	align: "right",
	 	autoclose: true,
	 	twelvehour: false,
		fromnow: 3600000
	});

	$(".srs-filter-checks .control").click(function(e) {
        $(this).parent().parent().find('.checked').removeClass('checked');
		$(this).addClass("checked");
	}).has('input:checked').addClass("checked");

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