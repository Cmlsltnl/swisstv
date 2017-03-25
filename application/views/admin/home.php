<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/admin.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/uniform.default.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/validationEngine.jquery.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/jquery-ui-1.8.13.custom.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/validation.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/validation-fr.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/admin.js"></script>
	<title>SwissTv admin</title>
</head>
<body>

    <div id="container">
        <?php echo $this->load->view('admin/partials/top'); ?>
        <?php echo $this->load->view('admin/partials/menu'); ?>
        <div id="content">
            <div id="infos_admin">
                <div id="infos_title">> Ajouter un quiz</div>
                <div id="infos_action"></div>
            </div>
            <?php
            $attributes = array('id' => 'add_quiz');
            echo form_open_multipart('admin/add_quiz', $attributes);?>
            <?php if(isset($message)){?><div id="message_info"><?php echo $message; ?></div><?php } ?>
            <div id="bloc_left">
                <label>Nom du quiz:</label><br/>
                <input type="text" name="name" value="" id="name" class="validate[required]"/><br/><br/>

                <label>Question FR:</label><br/>
                <input type="text" name="question_fr" value="" id="question_fr" class="validate[required]"/><br/><br/>
                <label>Question DE:</label><br/>
                <input type="text" name="question_de" value="" id="question_de" class="validate[required]"/><br/><br/>

                <label>Réponse FR:</label><br/>
                <input type="text" name="answer_fr" value="" id="answer_fr" class="validate[required]"/><br/><br/>
                <label>Réponse DE:</label><br/>
                <input type="text" name="answer_de" value="" id="answer_de" class="validate[required]"/><br/><br/>

                <label>Indice 1 FR:</label><br/>
                <input type="text" name="indice_1_fr" value="" id="indice_1_fr" class="validate[required]"/><br/><br/>
                <label>Indice 2 FR:</label><br/>
                <input type="text" name="indice_2_fr" value="" id="indice_2_fr" class="validate[required]"/><br/><br/>
                <label>Indice 3 FR:</label><br/>
                <input type="text" name="indice_3_fr" value="" id="indice_3_fr" class="validate[required]"/><br/><br/>

                <label>Indice 1 DE:</label><br/>
                <input type="text" name="indice_1_de" value="" id="indice_1_de" class="validate[required]"/><br/><br/>

            </div>

            <div id="bloc_right">
                <label>Indice 2 DE:</label><br/>
                <input type="text" name="indice_2_de" value="" id="indice_2_de" class="validate[required]"/><br/><br/>
                <label>Indice 3 DE:</label><br/>
                <input type="text" name="indice_3_de" value="" id="indice_3_de" class="validate[required]"/><br/><br/>
                <label>Type:</label><br/>
                <label>Image</label><input type="radio" name="media_type" checked="checked" value="1" />
                <label>Vidéo/Sons</label><input type="radio" name="media_type" value="2" /><br/><br/>

                <label>Media question(350x217):</label><br/>
                <input type="file" name="media_question"  value="" id="media_question" class="validate[required]"/><br/><br/>

                <label>Image réponse(320x195):</label><br/>
                <input type="file" name="media_answer"  value="" id="media_answer" class="validate[required]"/><br/><br/>

                <label>Jaquette réponse (90x130):</label><br/>
                <input type="file" name="cover_answer"  value="" id="cover_answer" class="validate[required]"/><br/><br/>

                <label>Date du quiz:</label><br/>
                <input type="text" name="date_quiz" value="" id="date_q" class="validate[required]"/><br/><br/>
                <label>Date du résultat:</label><br/>
                <input type="text" name="date_result" value="" id="date_r" class="validate[required]"/><br/><br/>
            </div>

            <div id="submit_form"><input type="button" name="add" id="add" value="Ajouter"/></div>
            <!--<div id="submit_form"><a href="#submit_form" id="add" >test</a></div>-->
            
            </form>
        </div>
    </div>

</body>
</html>
