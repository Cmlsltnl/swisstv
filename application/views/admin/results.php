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
                <div id="infos_title">> Résultats</div>
                <div id="infos_action"><a href="#" onclick="xajax_attribute_zero_point_process('<?php echo $quizId ?>')">Attribuer 0 pts</a></div>
            </div>
            <div id="user_table">
                <div class="row_title">
                    <div class="col_title">Prénom</div>
                    <div class="col_title">Nom</div>
                    <div class="col_title">Date de la réponse</div>
                    <div class="col_title">Réponse</div>
                    <div class="col_title">Points</div>
                    <div class="col_title">Action</div>
                </div>
                <?php 
                $i=0;
                $color=TRUE;
                foreach($allResponse as $response){ ?>

                    <form action="" name="form_response_<?php echo $i ?>" id="form_response_<?php echo $i ?>" >
                    <div <?php if($color){ ?>class="row_color"<?php $color=FALSE;}else{ $color=TRUE?> class="row" <?php } ?>>
                        <div class="col"><?php echo $response["first_name"]?></div>
                        <div class="col"><?php echo $response["last_name"]?></div>
                        <div class="col"><?php echo $response["date_answer"]?></div>
                        <div class="col"><?php if(!empty($response["user_answer"])){echo $response["user_answer"];}else{ echo "Aucune";}?></div>
                        <div class="col">
                            <select name="point" id="point">
                            <?php for($j=0;$j<=50;$j++){ ?>
                                <option value="<?php echo $j ?>" <?php $tab=explode(" ",$response["date_answer"]);$pt=classement::get_pt($response["user_id"], $tab[0]); if($j==$pt[0]["point"]){?> selected="selected" <?php } ?>><?php echo $j ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $response["user_id"]?>"/>
                        <input type="hidden" id="quiz_id" name="quiz_id" value="<?php echo $response["quiz_id"]?>"/>
                        <input type="hidden" id="date_answer" name="date_answer" value="<?php $tab=explode(" ",$response["date_answer"]);echo $tab[0]?>"/>
                        <input type="hidden" id="nb" name="nb" value="<?php echo $i ?>"/>
                        <div class="col" id="button_response_<?php echo $i ?>">
                            <?php if(!in_array($response["user_id"],$allPoint)){ ?>
                            <a href="#" onclick="xajax_add_point_process(xajax.getFormValues('form_response_<?php echo $i ?>'))">Attribuer</a>
                            <?php }else{ ?>
                            <a href="#" onclick="xajax_delete_point_process(xajax.getFormValues('form_response_<?php echo $i ?>'))">Retirer</a>
                            <?php } ?>
                        </div>
                    </div>
                    </form>
              
                <?php $i++;} ?>

            </div>
        </div>
    </div>

</body>
</html>
