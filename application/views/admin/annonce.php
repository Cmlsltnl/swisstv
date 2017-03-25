<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/admin.css" />
        <?php echo $this->xajax->printJavascript(base_url()); ?>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>

	<title>SwissTv admin</title>
</head>
<body>

    <div id="container">
        <?php echo $this->load->view('admin/partials/top'); ?>
        <?php echo $this->load->view('admin/partials/menu'); ?>
        <div id="content">
            <div id="infos_admin">
                <div id="infos_title">> Annonces</div>
                <div id="infos_action"><?php echo anchor('admin/add_annonce',"Ajouter"); ?></div>
            </div>
            <div id="user_table">
                <div class="row_title">
                    <div class="col_title">Titre</div>
                    <div class="col_annonce">Annonce FR</div>
                    <div class="col_title">Date</div>
                </div>
                <?php 
                $i=0;
                $color=TRUE;
                foreach($allAnnonce as $annonce){ ?>

                    <form action="" name="form_annonce_<?php echo $i ?>" id="form_annonce_<?php echo $i ?>" >
                    <div <?php if($color){ ?>class="row_color"<?php $color=FALSE;}else{ $color=TRUE?> class="row" <?php } ?>>
                        <div class="col"><?php echo $annonce["title"]?></div>
                        <div class="col_annonce"><?php echo substr($annonce["annonce_fr"],0,50)?></div>
                        <div class="col"><?php echo $annonce["date_annonce"]?></div>
                        <input type="hidden" id="annonce_id" name="annonce_id" value="<?php echo $annonce["annonce_id"]?>"/>
                        <input type="hidden" id="nb" name="nb" value="<?php echo $i ?>"/>
                        <div class="col" id="button_response_<?php echo $i ?>">
                            <a href="#" onclick="xajax_delete_annonce_process(xajax.getFormValues('form_annonce_<?php echo $i ?>'))">Retirer</a>
                        </div>
                    </div>
                    </form>
              
                <?php $i++;} ?>

            </div>
        </div>
    </div>

</body>
</html>
