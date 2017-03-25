<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/global_app.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/cadeaux_app.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/li-scroller.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.li-scroller.1.0.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/cadeaux.js"></script>
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
            <div id="list_cadeaux1">
                <div id="list_title1"><?php echo $this->lang->line('list_title_1') ?></div>
                <div id="cadeau_1">
                    <div id="cadeau_img_1"></div>
                    <div id="cadeau_title_1"><?php echo $this->lang->line('cadeau_1') ?></div>
                </div>
                <div id="cadeau_2">
                    <div id="cadeau_img_2"></div>
                    <div id="cadeau_title_2"><?php echo $this->lang->line('cadeau_2') ?></div>
                </div>
                <div id="cadeau_3">
                    <div id="cadeau_img_3"></div>
                    <div id="cadeau_title_3"><?php echo $this->lang->line('cadeau_3') ?></div>
                </div>
            </div>
            <div id="list_cadeaux2">
                <div id="list_title2"><?php echo $this->lang->line('list_title_2') ?></div>
                <div id="cadeau_4">
                    <div id="cadeau_img_4"></div>
                    <div id="cadeau_title_4"><?php echo $this->lang->line('cadeau_4') ?></div>
                </div>
                <div id="cadeau_5">
                    <div id="cadeau_img_5"></div>
                    <div id="cadeau_title_5"><?php echo $this->lang->line('cadeau_5') ?></div>
                </div>
                <div id="cadeau_6">
                    <div id="cadeau_img_6"></div>
                    <div id="cadeau_title_6"><?php echo $this->lang->line('cadeau_6') ?></div>
                </div>
            </div>
            <div id="list_cadeaux3">
                <div id="list_title3"><?php echo $this->lang->line('list_title_3') ?></div>
                <div id="cadeau_7">
                    <div id="cadeau_img_7"></div>
                    <div id="cadeau_title_7"><?php echo $this->lang->line('cadeau_7') ?></div>
                </div>
                <div id="cadeau_8">
                    <div id="cadeau_img_8"></div>
                    <div id="cadeau_title_8"><?php echo $this->lang->line('cadeau_8') ?></div>
                </div>
                <div id="cadeau_9">
                    <div id="cadeau_img_9"></div>
                    <div id="cadeau_title_9"><?php echo $this->lang->line('cadeau_9') ?></div>
                </div>
                <div id="cadeau_10">
                    <div id="cadeau_img_10"></div>
                    <div id="cadeau_title_10"><?php echo $this->lang->line('cadeau_10') ?></div>
                </div>
                <div id="cadeau_11">
                    <div id="cadeau_img_11"></div>
                    <div id="cadeau_title_11"><?php echo $this->lang->line('cadeau_11') ?></div>
                </div>
                <div id="cadeau_12">
                    <div id="cadeau_img_12"></div>
                    <div id="cadeau_title_12"><?php echo $this->lang->line('cadeau_12') ?></div>
                </div>
                <div id="cadeau_13">
                    <div id="cadeau_title_13"><?php echo $this->lang->line('cadeau_14') ?></div>
                    <div id="cadeau_img_13"></div>
                    <div id="cadeau_title_13"><?php echo $this->lang->line('cadeau_13') ?></div>
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
