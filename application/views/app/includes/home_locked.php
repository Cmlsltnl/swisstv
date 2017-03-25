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
                                                    height: 210, width: 342 });
                    </script>
                <?php }else{ ?>
                    <img src="<?php echo base_url() ?>uploads/<?php echo $quizInfos[0]["quiz_id"] ?>/<?php echo $quizInfos[0]["media_question"] ?>" alt="image question" />
                <?php } ?>

            <?php } ?>
        </div>
        <div id="indices">
           <div id="indice_1"></div>
           <div id="indice_2"></div>
           <div id="indice_3"></div>
        </div>
        <div id="popcorn"></div>
    </div>
    <div id="response_frame">
        <div id="question"><?php echo $quizInfos[0]["question_".$this->session->userdata('userLocale')] ?></div>
        <form>
                <input class="input_response" type="text" name="response" value="" />
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

