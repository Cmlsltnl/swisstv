<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/global_app.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/classement_app.css" />
         <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/jquery-ui-1.8.13.custom.css" />
        <?php echo $this->xajax->printJavascript(base_url()); ?>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/li-scroller.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.li-scroller.1.0.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/classement.js"></script>
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
            <div id="acces_frame">
                <div id="champions">
                    <div id="champions_title"><?php echo $this->lang->line('classement_champions_title') ?></div>
                    <div id="champions_content">
                        <?php for($i=6;$i<=11;$i++){
                            $champion=array();
                            $champion=$this->user_model->get_champion($i);
                        ?>

                        <div id="champion_<?php echo $i ?>">
                            <div class="champions_month"><?php echo date::month(date("Y-".$i."-d"),$this->session->userdata("userLocale"));  ?></div>
                        <?php if(empty($champion)){ ?>
                            <img src="<?php echo base_url() ?>img/fr/silouhette.png" alt="profile_pic"/>
                            <div class="champions_name">
                                <?php echo $this->lang->line('classement_champions') ?>
                            </div>
                        
                        <?php }else{
                                //FQL FACEBOOK QUERY
                                $fql = "SELECT pic FROM user WHERE uid=".$champion[0]["user_id"]." ";

                                $params  =   array(
                                'method'    => 'fql.query',
                                'access_token' => $this->session->userdata('access_token'),
                                'query'     => $fql,
                                'callback'  => ''
                                );

                                $fbPic = $this->facebook->api($params);
                        ?>
                            <img src="<?php echo $fbPic[0]["pic"]; ?>" alt="profile_pic" width="110px" height="110px" style="border:solid 1px #2c3c5a;"/>
                            <div class="champions_name">
                                <?php echo $champion[0]["first_name"]." ".$champion[0]["last_name"] ?>
                            </div>
                        <?php }?>
                        </div>
                        <?php }?>
                    </div>
                </div>
                <div id="classements">
                    <div id="bloc_left">
                        <div id="header_bloc_left">
                            <a href="#" onclick="xajax_next_week_process('<?php echo $week ?>','<?php echo $year ?>','<?php echo game::PREVIOUS_WEEK ?>','<?php echo game::CATEGORY_ALL ?>')"><div class="button_left"></div></a>
                            <div id="top_week"><?php echo $this->lang->line('classement_top_week');echo $week; ?></div>
                            <a href="#" onclick="xajax_next_week_process('<?php echo $week ?>','<?php echo $year ?>','<?php echo game::NEXT_WEEK ?>','<?php echo game::CATEGORY_ALL ?>')"><div class="button_right"></div></a>
                        </div>
                        <div id="content_bloc_left">
                            <?php foreach($classementWeek as $row){ ?>
                            
                            <div class="item_left">
                                <div class="item_left_pos">
                                    <?php echo classement::get_player_position_next_week($week,$year,$row["pt"], $row["user_id"]) ?>
                                </div>
                                <div class="item_left_img">
                                     <img src="https://graph.facebook.com/<?php echo $row["user_id"] ?>/picture"  />
                                </div>
                                <div class="item_left_name"><?php echo $row["first_name"]." ".$row["last_name"] ?></div>
                                <div class="item_left_pts">
                                <?php echo $row["pt"]?> <?php echo $this->lang->line('pts') ?>
                                </div>
                                <!--<div class="item_left_prog"><?php //echo classement::progression_week(classement::get_player_position_next_week($week,$year,$row["pt"], $row["user_id"]), $row["user_id"]) ?></div>-->
                            </div>
                            <?php } ?>
                        </div>
                        <div id="footer_bloc_left"></div>
                    </div>
                    <div id="bloc_right">
                        <div id="header_bloc_right">
                            <a href="#" onclick="xajax_next_month_process('<?php echo $month ?>','<?php echo $year ?>','<?php echo game::PREVIOUS_MONTH ?>','<?php echo game::CATEGORY_ALL ?>')"><div class="button_left"></div></a>
                            <div id="top_month"><?php echo $this->lang->line('classement_top_month');echo date::month(date("Y-".$month."-d"), $this->session->userdata("userLocale")) ?></div>
                            <a href="#" onclick="xajax_next_month_process('<?php echo $month ?>','<?php echo $year ?>','<?php echo game::NEXT_MONTH ?>','<?php echo game::CATEGORY_ALL ?>')"><div class="button_right"></div></a>
                        </div>
                        <div id="content_bloc_right">
                            <?php foreach($classementMonth as $row){ ?>
                            <div class="item_right">
                                <div class="item_right_pos"><?php echo classement::get_player_position_monthly($row["pt"], $row["user_id"]) ?></div>
                                <div class="item_right_img">

                                    <img src="https://graph.facebook.com/<?php echo $row["user_id"] ?>/picture"  />
                                </div>
                                <div class="item_right_name"><?php echo $row["first_name"]." ".$row["last_name"] ?></div>
                                <div class="item_right_pts">
                                <?php echo $row["pt"]?> <?php echo $this->lang->line('pts') ?> <br/>
                                <?php
                                    $parrainage=classement::get_parrainage_month($row["user_id"], $month, $year);
                                    if(!empty($parrainage)){
                                        if(!empty($parrainage[0]["point"])){$nb_parrainage=$parrainage[0]["point"];}else{$nb_parrainage="0";}
                                        echo "<em>(".$nb_parrainage." ".$this->lang->line('pts').")</em>";
                                    }
                                ?>
                                </div>
                                <div class="item_right_prog"><?php //echo classement::progression_month(classement::get_player_position_monthly($row["pt"], $row["user_id"]), $row["user_id"]) ?></div>
                            </div>
                            <?php  } ?>
                        </div>
                        <div id="footer_bloc_right"></div>
                    </div>
                    <div id="classement_access">
                        <?php echo anchor("game/classement",$this->lang->line('classement_general')) ?>
                        <a href="#" onclick="xajax_friends_process()"><?php echo $this->lang->line('classement_amis') ?></a>
                        <a href="#" onclick="xajax_my_classement_process()"><?php echo $this->lang->line('classement_me') ?></a>
                    </div>
                </div>
                <div id="defi">
                    <h4><a href="#" onclick="invite()"><?php echo $this->lang->line('home_defi_title') ?></a></h4>
                    <div id="defi_text"><?php echo $this->lang->line('home_defi_text') ?></div>
                </div>
            </div>

        </div>
        <?php echo $this->load->view('app/partials/footer'); ?>
    </div>
</body>
</html>

