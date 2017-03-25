            <div id="infos_admin">
                <div id="infos_title">> Liste des quiz</div>
                <div id="infos_action">
                    <div class="item_action"><?php echo anchor("admin/list_quiz","Liste des quiz"); ?> | </div>
                    <div class="item_action">
                    <form method="post" name="form_search_quiz" id="form_search_quiz" >
                        <label>Date:</label>
                        <input type="text" name="date_quiz" id="date_quiz" value="" />
                        <a href="#" onclick="xajax_search_quiz_by_date_process(xajax.getFormValues('form_search_quiz'))">Rechercher</a>

                    </form>
                    </div>
                </div>
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
                    <div class="media_preview"><?php echo anchor("admin/results/".$quiz["quiz_id"],"Résultats"); ?></div>
                    <div class="media_preview"><?php echo anchor("admin/preview/".$quiz["quiz_id"],"Aperçu","target='_blank'"); ?></div>
                    <div class="media_modify"><?php echo anchor("admin/modify/".$quiz["quiz_id"],"Modifier"); ?></div>
                    <div class="media_delete"><a href="#" onclick="xajax_delete_quiz_process('<?php echo $quiz["quiz_id"] ?>')">Supprimer</a></div>
                </div>
            </div>
            <?php } ?>