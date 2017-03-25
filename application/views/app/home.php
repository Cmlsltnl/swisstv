<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/global_app.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/home_app.css" />

        <?php echo $this->xajax->printJavascript(base_url()); ?>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/li-scroller.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.li-scroller.1.0.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/home.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>mediaplayer/jwplayer.js"></script>
	<title>SwissTv</title>
</head>
<body>
<?php echo $this->load->view('includes/facebook_js'); ?>
<script type="text/javascript">
$(document).ready(function() {

    $("#button").click(function() {
        
        if((navigator.userAgent.match(/iPhone/i))||(navigator.userAgent.match(/iPod/i))){

            xajax_submit_response_process(xajax.getFormValues('response_form'));

        }else{



                FB.ui(
                {
                 method: 'feed',
                 name: 'Hollywood Quiz',
                 link: 'http://apps.facebook.com/hollywoodquiz/',
                 picture: 'http://game.swisstvquiz.com/img/fr/logo_75.png',
                 caption: 'SwissTv - Hollywood Quiz',
                 description: '<?php echo $this->lang->line('home_feed_desc')   ?>',
                 message: '<?php echo $this->lang->line('home_feed_msg')   ?>'
                },
                function(response) {
                 if (response && response.post_id) {
                          xajax_submit_response_process(xajax.getFormValues('response_form'));
                 } else {
                          xajax_submit_response_process(xajax.getFormValues('response_form'));
                 }
                }
                );


        }
    });
});

/*Invite friends request 2.0 */
function invite(){
    FB.ui({ method: 'apprequests',
      title: '<?php echo $this->lang->line('menu_invite_title') ?>',
      data: '<?php echo $this->session->userdata('userId') ?>',
      message: '<?php echo $this->lang->line('menu_invite_message') ?>'});
}
</script>
    <div id="container">
        
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
                            <img src="<?php echo base_url() ?>uploads/<?php echo $quizInfos[0]["quiz_id"] ?>/<?php echo $quizInfos[0]["media_question"] ?>" height="215px" width="348px" alt="image question" />
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
                <div id="question"><?php if(!empty($quizInfos)){echo substr($quizInfos[0]["question_".$this->session->userdata('userLocale')], 0, 50);}else{ echo $message_info;} ?></div>
                
                <form name="response_form" id="response_form">
                        <div class="input_response"><input  type="text" id="user_answer" name="user_answer" value="" /></div>
                        <?php if(!empty($quizInfos)){ ?><input type="hidden" id="quiz_id" name="quiz_id" value="<?php echo $quizInfos[0]["quiz_id"] ?>" /><?php } ?>
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $this->session->userdata('userId') ?>" />
                        <?php if(!empty($quizInfos)){ ?><div id="button"></div><?php } ?>
                </form>
                
                <div id="infos_response"><?php echo $this->lang->line('home_infos_response') ?></div>
            </div>
            <div id="acces_frame">
                <div id="box"></div>
                <div id="defi">
                    <h4><a href="#" onclick="invite()"><?php echo $this->lang->line('home_defi_title') ?></a></h4>
                    <div id="defi_text"><?php echo $this->lang->line('home_defi_text') ?></div>
                </div>
            </div>
        </div>
        <?php echo $this->load->view('app/partials/footer'); ?>
    </div>
</body>
</html>
