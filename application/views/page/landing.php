<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $lang ?>/global_page.css" />
	<title>SwissTv</title>
</head>
<body>

<?php echo $this->load->view('includes/facebook_js'); ?>

<script>
    
FB.Event.subscribe("edge.create", function(response) {

    top.location.href='<?php echo PAGE_FAN_APP_URL ?>';

});


</script>
    
    <div id="container">

        <?php if(empty($liked)){ ?>

        <div id="landing_image">
            <div id="lang_landing">
               <?php echo anchor('start/index/fr','FR',array('id'=>'link_fr'))?>
               <?php echo anchor('start/index/de','DE',array('id'=>'link_de'))?>
            </div>
            <div id="like_button">
                <fb:like  href="<?php echo PAGE_FAN_URL ?>" show_faces="False"   layout="button_count"></fb:like>
            </div>
        </div>
        
        <?php }else{ ?>

        <div id="access_image">
            <div id="lang_access">
               <?php echo anchor('start/index/fr','FR',array('id'=>'link_fr'))?>
               <?php echo anchor('start/index/de','DE',array('id'=>'link_de'))?>
            </div>
            <?php echo anchor('start/app_access','<div id="play"></div>',array('id'=>'link_access'))?>
        </div>

        <?php } ?>
        
    </div>
    
</body>
</html>