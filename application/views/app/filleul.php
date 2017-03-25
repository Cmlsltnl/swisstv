<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/global_app.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/filleul_app.css" />
        <?php echo $this->xajax->printJavascript(base_url()); ?>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/li-scroller.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.li-scroller.1.0.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/filleul.js"></script>
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
            <div id="filleul">
                <div id="title_filleul"><?php echo $this->lang->line('filleul_title') ?></div>
                <div id="nb_filleul">
                        <?php echo $nbFilleul ?> <?php echo $this->lang->line('filleul_sur') ?> <?php echo $nbUser ?> <?php echo $this->lang->line('filleul_participants') ?>
                        , <?php echo date::month(date("Y-m-d"), $this->session->userdata("userLocale"));  ?> = <?php echo $nbParrainage;?> <?php echo $this->lang->line('filleul') ?> = <?php if(!empty($totalPts[0]["pt"])){echo $totalPts[0]["pt"];}else{ echo "0";} ?> <?php echo $this->lang->line('point') ?>
                        <br/><?php echo $this->lang->line('explication') ?>
                </div>
                <div id="list_filleul">

                    <?php $i=0; foreach($filleuls as  $row){?>

                    <div <?php if($i==2){ $i=0;?>class="item_filleul_alt"<?php }else{ $i++;?>class="item_filleul"<?php } ?> >
                        <img src="https://graph.facebook.com/<?php echo $row["user_id"] ?>/picture"  />
                        <div id="user_infos">
                            <div id="user_position"><?php echo classement::get_player_position_monthly($row["pt"],$row["user_id"]) ?></div>
                            <div id="user_points"><?php echo $row["pt"]; ?> <?php echo $this->lang->line('pts') ?></div>
                        </div>

                        <div id="user_identity"><div id="user_name"><?php echo $row["first_name"]; ?> <?php echo $row["last_name"];?></div></div>
                    </div>

                    <?php } ?>

                </div>
                <div id="ajax_pagination">

                    <?php
                    foreach($pagination as $row){
                        echo $row;
                    }
                    ?>

                </div>
            </div>
            <div id="defi">
                <h4><a href="#" onclick="invite()"><?php echo $this->lang->line('home_defi_title') ?></a></h4>
                <div id="defi_text"><?php echo $this->lang->line('home_defi_text') ?></div>
            </div>
        </div>
        <?php echo $this->load->view('app/partials/footer'); ?>
    </div>

</body>
</html>
