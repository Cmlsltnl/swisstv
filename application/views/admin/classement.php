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
                <div id="infos_title">> Champion du mois de <?php echo date::month(date("Y-".$month."-d"), $this->session->userdata("userLocale")) ?></div>
                <div id="infos_action">
            <?php $attributes = array('id' => 'search_month');
            echo form_open_multipart('admin/classement', $attributes);?>
                        <select name="month">
                            <option value="05">Mai</option>
                            <option value="06">Juin</option>
                            <option value="07">Juillet</option>
                            <option value="08">Aout</option>
                            <option value="09">Septembre</option>
                            <option value="10">Octobre</option>
                            <option value="11">Novembre</option>
                            <option value="12">Décembre</option>
                        </select>
                        <input type="submit" name="submit" value="Rechercher" />
                    </form>
                </div>
            </div>
            <div id="user_table">
                <div class="row_title">
                    <div class="col_title">Position</div>
                    <div class="col_title">Nom</div>
                    <div class="col_email">Email</div>
                    <div class="col_title">Pts</div>
                </div>
                <?php 
                $i=0;
                $color=TRUE;
                foreach($classementMonth as $row){ ?>

                    <form action="" name="form_champion_<?php echo $i ?>" id="form_champion_<?php echo $i ?>" >
                    <div <?php if($color){ ?>class="row_color"<?php $color=FALSE;}else{ $color=TRUE?> class="row" <?php } ?>>
                        <div class="col"><?php echo classement::get_player_position_next_month($month,$year,$row["pt"],$row["user_id"]); //classement::get_player_position_monthly($row["pt"],$row["user_id"]);  ?></div>
                        <div class="col"><?php echo $row["first_name"]." ".$row["last_name"] ?></div>
                        <div class="col_email"><?php echo $row["email"] ?></div>
                        <div class="col"><?php echo $row["pt"] ?></div>
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $row["user_id"] ?>"/>
                        <input type="hidden" id="nb" name="nb" value="<?php echo $i ?>"/>
                        <input type="hidden" id="date_point" name="date_point" value="<?php echo $row["date_point"] ?>"/>
                        <div class="col" id="button_response_<?php echo $i ?>">
                            <?php if($row["user_id"]==$champion){ ?>
                                <a href="#" >Champion</a>
                            <?php }else{ ?>
                                <a href="#" onclick="xajax_champion_process(xajax.getFormValues('form_champion_<?php echo $i ?>'))">Désigner champion</a>
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
