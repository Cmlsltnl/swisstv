$(document).ready(function() {

    $("select,textarea ,input:text,input:password, input:radio, input:file").uniform();


    $( "#date_q" ).datepicker({ dateFormat: 'yy-mm-dd',dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre']});
    $( "#date_r" ).datepicker({ dateFormat: 'yy-mm-dd',dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre']});

    $("#add").click(function(){
        
        var validation=$("#add_quiz").validationEngine('validate',{scroll: true});

        if(validation){
           $("#add_quiz").submit();
        }
    });

    $("#modify").click(function(){

        var validation=$("#modify_quiz").validationEngine('validate',{scroll: true});

        if(validation){
           $("#modify_quiz").submit();
        }
    });

});


