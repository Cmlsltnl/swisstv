<div id="infos_admin">
    <div id="infos_title">> Liste des quiz</div>
    <div id="infos_action"></div>
</div>
<?php foreach($allQuiz as $quiz){ ?>
<div class="quiz_item">
    <div class="header_item">
        <div class="quiz_title"><?php echo $quiz["name"] ?></div>
        <div class="quiz_date"><?php echo $quiz["date_quiz"] ?></div>
    </div>
    <div class="content_item">
        <div class="question_item">Q: <?php echo  $quiz["question_fr"] ?></div>
        <div class="reponse_item">R: <?php echo $quiz["answer_fr"] ?></div>
    </div>
    <div class="quiz_action">
        <div class="media_preview"><?php echo anchor("admin/result/","Résultats"); ?></div>
        <div class="media_preview"><?php echo anchor("admin/preview/","Aperçu"); ?></div>
        <div class="media_modify"><?php echo anchor("admin/modify/".$quiz["quiz_id"],"Modifier"); ?></div>
        <div class="media_delete"><a href="#" onclick="xajax_delete_quiz_process('<?php echo $quiz["quiz_id"] ?>')">Supprimer</a></div>
    </div>
</div>
<?php } ?>

