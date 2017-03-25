$(document).ready(function() {

    $("#calendar").datepicker({dateFormat: 'yy-mm-dd',dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fre', 'Sa'],monthNames: ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','December'],onSelect: function(date) {
                                    xajax_date_picker_process(date);
                                }
    });
    
    $("ul#ticker01").liScroll();
});


