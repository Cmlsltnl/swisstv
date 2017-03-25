<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/global_app.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/mission_app.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/li-scroller.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.li-scroller.1.0.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/mission.js"></script>
	<title>SwissTv</title>
</head>
<body>

<?php echo $this->load->view('includes/facebook_js'); ?>
<script type="text/javascript">
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
            <?php echo $this->load->view('app/partials/menu'); ?>
            <div id="content_1">
                <div class="citation"><?php echo $this->lang->line("mission_citation_1") ?></div>
                <div class="traduction"><?php echo $this->lang->line("mission_original_1")." <b>".$this->lang->line("mission_original_title_1")."</b>" ?></div>
            </div>
            <div id="content_2">
                <div class="title"><?php echo $this->lang->line("mission_title_2") ?></div>
                <div class="text"><?php echo $this->lang->line("mission_content_2") ?></div>
            </div>
            <div id="content_3">
                <div class="citation"><?php echo $this->lang->line("mission_citation_2") ?></div>
                <div class="traduction"><?php echo $this->lang->line("mission_original_2")." <b>".$this->lang->line("mission_original_title_2")."</b> " ?></div>
            </div>
            <div id="content_4">
                <div class="title"><?php echo $this->lang->line("mission_title_4") ?></div>
                <div class="text"><?php echo $this->lang->line("mission_content_4") ?></div>
            </div>
            <div id="content_5">
                <div class="citation"><?php echo $this->lang->line("mission_citation_3") ?></div>
                <div class="traduction"><?php echo $this->lang->line("mission_original_3")." <b>".$this->lang->line("mission_original_title_3")."</b>" ?></div>
            </div>
            <div id="content_6">
                <div class="title"><?php echo $this->lang->line("mission_title_6") ?></div>
                <div class="text"><?php echo $this->lang->line("mission_content_6") ?></div>
            </div>
            <div id="box"></div>
            <div id="defi">
                <h4><a href="#" onclick="invite()"><?php echo $this->lang->line('home_defi_title') ?></a></h4>
                <div id="defi_text"><?php echo $this->lang->line('home_defi_text') ?></div>
            </div>
        </div>
        <?php echo $this->load->view('app/partials/footer'); ?>
    </div>

</body>
</html>
