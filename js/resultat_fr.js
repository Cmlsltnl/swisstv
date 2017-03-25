$(document).ready(function() {

    $("#calendar").datepicker({dateFormat: 'yy-mm-dd',dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],onSelect: function(date) {
                                    xajax_date_picker_process(date);
                                }
    });

    $("ul#ticker01").liScroll();
});


