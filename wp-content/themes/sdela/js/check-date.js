;(function($){    
    var strCurrDate; // Current date as a string
    var today = new Date(); // Current date as a timestamp
    var dtCurrDate; // Current date as a timestamp
    var dtStart, strStart;
    
    
    // Initialise strCurrDstrCurrDate, and dtCurrDate
    $(document).ready(function(){        
        var day = today.getDate();
        var month = (today.getMonth()+1) < 10 ? '0' + (today.getMonth()+1): (today.getMonth()+1);
        var year = today.getFullYear();
        strCurrDate = day + '.' + month + '.' + year;
        dtCurrDate = makeCompareDates(day + '.' + month + '.' + year);
    });
    
    // Compares start and finish dates and returns true if dates are accepted
    // Dates for comparison are timestamps
    var isDateAccepted = function(start, finish, obj) {
        if(!isNaN(start) && !isNaN(finish)) {
            if(start > finish) {            
                $(obj).focus().select();
                return false;
            }
        }         
        $('.alert.alert-danger').remove();
        return true;
    };
    
    // Checks whether start and finish dates is equals
    // Dates are timestamps
    var datesIsEquals = function(start, finish) {
        if (start === finish) {            
            return true;
        }        
        return false;
    };
    
    // Date represented as a string transforms to the american date format and 
    // transforms to timestamp after this 
    var makeCompareDates = function (dt) {
        dateAr=dt.split(".");
        var newDate=dateAr[2]+"-"+dateAr[1]+"-"+dateAr[0];
        return new Date(newDate).getTime();
    };
    
    // Alerts message
    var alertDateMessage = function() {
        $('.alert.alert-danger').remove();
        $('<div class="alert alert-danger" role="alert">Проверьте значения дат начала и окончания.</div>').insertBefore(".w2dc-description-big");
    };
    
    $('#w2dc-field-input-9').datepicker({
        minDate: new Date(),
        onClose: function() {  
            var start = makeCompareDates($(this).val());
            var finish = makeCompareDates($('#w2dc-field-input-10').val());
            
            //$('input[name="w2dc-field-input-9"]').val(start);
            $('input[name="w2dc-field-input-9"]').val(start/1000);
            
            if(!isDateAccepted(start, finish, this)) {
                alertDateMessage();
            }
            
            setFinishHour(datesIsEquals(start, finish));            
        }
    });
    
    $('#w2dc-field-input-9').focusout(function(){
        var val = makeCompareDates($(this).val());        
        
        if((val < dtCurrDate) || (isNaN(val))){
            $(this).val(strCurrDate).focus().select();
            alertDateMessage();
        } 

    });
    
    $('#w2dc-field-input-10').datepicker({
        minDate: new Date(),
        onClose: function() {            
            var finish = makeCompareDates($(this).val());
            var start = makeCompareDates($('#w2dc-field-input-9').val());
            
            //$('input[name="w2dc-field-input-10"]').val(finish);
            $('input[name="w2dc-field-input-10"]').val(finish/1000);
       
            if(!isDateAccepted(start, finish, this)) {
                alertDateMessage();
                return;
            }
            
            setFinishHour(datesIsEquals(start, finish));
        }
    });   
    
    $('#w2dc-field-input-10').focusout(function(){        
        var val = makeCompareDates($(this).val());

        dtStart = $('input[name="w2dc-field-input-9"]').val();
        strStart = $('#w2dc-field-input-9').val();
        
        if((val < dtStart) || (isNaN(val))){
            $(this).val(strStart).focus().select();
            alertDateMessage();
        }
    });
    
    var setFinishHour = function(isEquals) {
        if(!isEquals) {            
            setAllEnabled();            
            $('select[name="w2dc-field-input-hour_10"]>option:eq(0)').attr('disabled', false);
        }
        if(isEquals) {
            var idx = parseInt($('select[name="w2dc-field-input-hour_9"]').val());
            setAllEnabled();
            setDisabled(idx);
            setFirstSelected(idx);
        }
    };
    
    var setDisabled = function(sh){
        $('select[name="w2dc-field-input-hour_10"]>option').each(function() {
            if(parseInt(sh) >= parseInt($(this).val())) {
                $(this).attr('disabled', 'disabled');
            }
        });
    };
    
    var setFirstSelected = function(sh){
        $('select[name="w2dc-field-input-hour_10"]>option').each(function() {
            if(parseInt($(this).val()) === (parseInt(sh) + 1)) {
                $(this).attr('selected','selected');
                return;
            }
        });
    };
    
    var setAllEnabled = function(){
        $('select[name="w2dc-field-input-hour_10"]>option').each(function() {
            $(this).attr('disabled', false);
            if($(this).val() === '00') {
                $(this).attr('selected','selected');
            }
        });
    };
    
    $('select[name="w2dc-field-input-hour_9"]').change(function(){
        setAllEnabled();
        var sh = $(this).val();
        setDisabled(sh);        
        setFirstSelected(sh);
    });
    
})(jQuery);