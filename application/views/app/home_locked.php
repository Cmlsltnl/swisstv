<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/global_app.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/home_app.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/jquery.countdown.css" />
        <?php echo $this->xajax->printJavascript(base_url()); ?>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.countdown.js"></script>
       <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/li-scroller.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.li-scroller.1.0.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>mediaplayer/jwplayer.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/home_locked.js"></script>
	<title>SwissTv</title>
</head>
<body>
<script type="text/javascript">
$(document).ready(function() {

    xajax_update_indice1_process();
    xajax_update_indice2_process();
    xajax_update_indice3_process();
    

    $('#countdown_next_quiz').countdown({until: new Date('<?php echo $dateNextQuiz[0] ?>', '<?php echo $dateNextQuiz[1] ?>'-1,'<?php echo $dateNextQuiz[2] ?>',12,1,0),compact: true,format: 'HMS',onExpiry: xajax_reload_process});
    $('#countdown_next_result').countdown({until: new Date('<?php echo $dateResult[0] ?>','<?php echo $dateResult[1] ?>'- 1,'<?php echo $dateResult[2] ?>',12,0,0),compact: true,format: 'HMS'});

});

/*Invite friends request 2.0 */
function invite(){
    FB.ui({ method: 'apprequests',
      title: '<?php echo $this->lang->line('menu_invite_title') ?>',
      data: '<?php echo $this->session->userdata('userId') ?>',
      message: '<?php echo $this->lang->line('menu_invite_message') ?>'});
}
</script>
<?php echo $this->load->view('includes/facebook_js'); ?>

    <div id="container">
            <a href="#" onclick="invite()"><div id="defi_lock"></div></a>
            <div id="ruban">
                <div id="next_quiz"><div id="text_next_quiz"><?php echo $this->lang->line('home_next_quiz') ?></div><div id="countdown_next_quiz"></div></div>
                <div id="next_result"><div id="text_next_result"><?php echo $this->lang->line('home_next_result') ?></div><div id="countdown_next_result"></div></div>
            </div>
            <div id="lock"></div>
            <?php echo $this->load->view('app/partials/header'); ?>
        <div id="content">
            <div id="screen_frame">
                <?php echo $this->load->view('app/partials/menu'); ?>
                <div id="contest_infos">
                    <div id="contest_date"><h3><?php echo $this->lang->line('home_date') ?></h3></div>
                    <div id="contest_title"><h1> <?php echo $this->lang->line('home_title1') ?> </h1> <h2> <?php echo $this->lang->line('home_title2') ?> </h2></div>
                </div>
                <div id="screen">
                    <?php if(!empty($quizInfos)){ ?>

                        <?php if($quizInfos[0]["type"]==2){ ?>
                            <div id="video">Loading the player ...</div>
                            <script type="text/javascript">
                                jwplayer("video").setup({ flashplayer: "<?php echo base_url() ?>mediaplayer/player.swf",
                                                            file: "<?php echo base_url() ?>uploads/<?php echo $quizInfos[0]["quiz_id"] ?>/<?php echo $quizInfos[0]["media_question"] ?>",
                                                            height: 215, width: 348 });
                            </script>
                        <?php }else{ ?>
                            <img src="<?php echo base_url() ?>uploads/<?php echo $quizInfos[0]["quiz_id"] ?>/<?php echo $quizInfos[0]["media_question"] ?>" alt="image question" height="215px" width="348px" />
                        <?php } ?>

                    <?php } ?>
                </div>
                <div id="indices">
                   <div id="indice_1"></div>
                   <!--<div id="indice_2"></div>
                   <div id="indice_3"></div>-->
                </div>
                <div id="popcorn"></div>  
            </div>
            <div id="response_frame">
                <div id="question"><?php echo substr($quizInfos[0]["question_".$this->session->userdata('userLocale')], 0, 50); ?></div>
                <form name="response_form" id="response_form">
                        <input class="input_response" type="text" id="user_answer" name="user_answer" value="" />
                        <input type="hidden" id="response" name="quiz_id" value="<?php echo $quizInfos[0]["quiz_id"] ?>" />
                        <input type="hidden" id="response" name="user_id" value="<?php echo $this->session->userdata('user_id') ?>" />
                        <div id="button"></div>
                </form>
                <div id="infos_response"><?php echo $this->lang->line('home_infos_response') ?></div>
            </div>
            <div id="acces_frame">
                <div id="box"></div>
                <div id="defi">
                    <h4><?php echo $this->lang->line('home_defi_title') ?></h4>
                    <div id="defi_text"><?php echo $this->lang->line('home_defi_text') ?></div>
                </div>
            </div>
        </div>
        <?php echo $this->load->view('app/partials/footer'); ?>
    </div>
</body>
</html>
