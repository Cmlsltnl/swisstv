<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/global_app.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/mon_compte_app.css" />
        <?php echo $this->xajax->printJavascript(base_url()); ?>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/li-scroller.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.li-scroller.1.0.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/mon_compte.js"></script>
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
            <div id="mon_compte">
                <div id="mon_compte_title"><?php echo $this->lang->line('compte_title') ?></div>
                <div id="mon_compte_desc"><?php echo $this->lang->line('compte_desc') ?></div>
                <div id="mon_compte_form">
                    <form name="compte_form_submit" id="compte_form_submit">
                    <div id="mon_compte_input"><input type="text" id="account" name="account" value="<?php if(!empty($userInfos[0]["swisstv_account"]))echo $userInfos[0]["swisstv_account"] ?>" /></div>
                    <div id="mon_compte_valider"><?php echo $this->lang->line('validation_compte') ?></div>
                    </form>
                </div>
            </div>
            <div id="newsletter">
                <div id="newsletter_title"><?php echo $this->lang->line('newsletter_title') ?></div>
                <div id="newsletter_desc"><input type="checkbox" checked="checked" id="autorisation_newsletter" name="autorisation_newsletter" value="1" /> <?php echo $this->lang->line('newsletter_desc') ?></div>
                <div id="newsletter_form">
                    <form name="newsletter_form_submit" id="newsletter_form_submit">
                    <div id="newsletter_input"><input type="text" id="newsletter" name="newsletter" value="<?php if(!empty($userInfos[0]["newsletter"]))echo $userInfos[0]["newsletter"] ?>" /></div>
                    <div id="newsletter_valider"><?php echo $this->lang->line('validation_newsletter') ?></div>

                    </form>
                </div>
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
