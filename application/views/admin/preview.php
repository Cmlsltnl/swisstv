<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/admin.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>mediaplayer/jwplayer.js"></script>
	<title>SwissTv admin</title>
</head>
<body>

    <div id="container">
        <?php echo $this->load->view('admin/partials/top'); ?>
        <?php echo $this->load->view('admin/partials/menu'); ?>
        <div id="content">
            <div id="infos_admin">
                <div id="infos_title">> Aperçu du média en question</div>
                <div id="infos_action"></div>
                
            </div>
            <div class="preview">
                <?php if(!empty($quizInfos)){ ?>

                        <?php if($quizInfos[0]["type"]==2){ ?>
                            <div id="video" class="item_preview">Loading the player ...</div>
                            <script type="text/javascript">
                                jwplayer("video").setup({ flashplayer: "<?php echo base_url() ?>mediaplayer/player.swf",
                                                            file: "<?php echo base_url() ?>uploads/<?php echo $quizInfos[0]["quiz_id"] ?>/<?php echo $quizInfos[0]["media_question"] ?>",
                                                            height: 210, width: 342 });
                            </script>
                        <?php }else{ ?>
                            <div class="item_preview"><img src="<?php echo base_url() ?>uploads/<?php echo $quizInfos[0]["quiz_id"] ?>/<?php echo $quizInfos[0]["media_question"] ?>" alt="image question" /></div>
                        <?php } ?>
                            <div class="item_preview"><img src="<?php echo base_url() ?>uploads/<?php echo $quizInfos[0]["quiz_id"] ?>/<?php echo $quizInfos[0]["image_answer"] ?>" alt="image reponse" /></div>
                            <div class="item_preview"><img src="<?php echo base_url() ?>uploads/<?php echo $quizInfos[0]["quiz_id"] ?>/<?php echo $quizInfos[0]["cover_answer"] ?>" alt="image reponse" /></div>
                <?php } ?>
            
            </div>
        </div>
    </div>

</body>
</html>
