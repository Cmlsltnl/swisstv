$(document).ready(function() {

    $("#mon_compte_valider").click(function() {
        xajax_submit_account_process(xajax.getFormValues('compte_form_submit'));
    });

    $("#newsletter_valider").click(function() {

        var check=$('#autorisation_newsletter').is(':checked');

        if(check)
            xajax_submit_newsletter_process(xajax.getFormValues('newsletter_form_submit'));
        
    });

    $("ul#ticker01").liScroll();

});


