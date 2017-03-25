<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/global_app.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?php echo $this->session->userdata('userLocale') ?>/resultat_app.css" />
         <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/jquery-ui-1.8.13.custom.css" />
        <?php echo $this->xajax->printJavascript(base_url()); ?>

        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/li-scroller.css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.li-scroller.1.0.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/resultat_<?php echo $this->session->userdata('userLocale') ?>.js"></script>
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
                <div id="bloc_left">
                    <div id="my_resultat">
                        <div id="infos">
                            <div id="date_infos">
                                <div id="quiz"><?php echo $this->lang->line('resultat_quiz') ?></div>
                                <div id="date"><?php if(!empty($quizInfos)){ $tab=explode("-",$quizInfos[0]["date_quiz"]);echo $tab[2]." ".date::month($quizInfos[0]["date_quiz"], $this->session->userdata("userLocale")); } ?></div>
                            </div>
                            <div id="your_result">
                            <?php
                                //FQL FACEBOOK QUERY
                                $fql = "SELECT pic_square FROM user WHERE uid=".$this->session->userdata("userId")." ";

                                $params  =   array(
                                'method'    => 'fql.query',
                                'access_token' => $this->session->userdata('access_token'),
                                'query'     => $fql,
                                'callback'  => ''
                                );

                                $fbPic = $this->facebook->api($params);
                            ?>
                                <img src="<?php if(!empty($fbPic))echo $fbPic[0]["pic_square"]; ?>" />
                                <div id="user_ranking">
                                    <div id="user_position"><?php if(!empty($userPoints[0]["point"])&&!empty($quizInfos)&&date("Y-m-d H:i:s")>=$quizInfos[0]['date_result'].' 12:00:00'){echo classement::get_player_position_daily($userPoints[0]["point"],$this->session->userdata("userId"),$quizInfos[0]["date_quiz"]); }else{ echo $this->lang->line('resultat_point'); } ?></div>
                                    <div id="user_point"><?php if(!empty($userPoints[0]["point"])&&!empty($quizInfos)&&date("Y-m-d H:i:s")>=$quizInfos[0]['date_result'].' 12:00:00'){echo $userPoints[0]["point"]; ?> <?php echo $this->lang->line('pts') ?> <?php } ?></div>
                                </div>
                                
                                <div id="user_name"><?php echo substr($this->session->userdata("userFirstName")." ".$this->session->userdata("userLastName"),0,15); ?></div>
                            </div>
                        </div>
                        <div id="calendar"></div>
                    </div>
                    <div id="resultat_response">
                        <?php
                        if(!empty($quizInfos)){
                            if(date("Y-m-d H:i:s")>=$quizInfos[0]['date_result'].' 12:00:00'){ ?>

                        <div id="question"><?php if(!empty($quizInfos))echo substr($quizInfos[0]["question_".$this->session->userdata('userLocale')], 0, 50) ?></div>
                        <div id="image"><?php if(!empty($quizInfos)) {?><img src="<?php echo base_url() ?>uploads/<?php echo $quizInfos[0]["quiz_id"] ?>/<?php echo $quizInfos[0]["image_answer"] ?>" height="195px" width="320px"/><?php } ?></div>
                        <div id="jaquette"><?php if(!empty($quizInfos)) {?><img src="<?php echo base_url() ?>uploads/<?php echo $quizInfos[0]["quiz_id"] ?>/<?php echo $quizInfos[0]["cover_answer"] ?>" height="130px" width="90px" /><?php } ?></div>
                        <div id="response"><?php if(!empty($quizInfos))echo substr($quizInfos[0]["answer_".$this->session->userdata('userLocale')], 0, 40)  ?></div>
                        <?php }

                        }?>
                    </div>
                </div>
                <div id="bloc_right">
                    <div id="top_day">
                        <div id="header_top_day">
                            <h1><?php echo $this->lang->line('resultat_top') ?></h1>
                            <h2><?php if(!empty($quizInfos)){ $tab=explode("-",$quizInfos[0]["date_quiz"]);echo $tab[2]." ".date::month($quizInfos[0]["date_quiz"], $this->session->userdata("userLocale")); }  ?></h2>
                        </div>
                        <div id="list_item">
                        <?php
                        if(!empty($quizInfos)){
                            if(date("Y-m-d H:i:s")>=$quizInfos[0]['date_result'].' 12:00:00'){ ?>


                        <?php foreach($resultats as $row){ ?>
                            <div class="your_result">

                                <img src="https://graph.facebook.com/<?php echo $row["user_id"] ?>/picture"  />
                                <div class="user_ranking">
                                    <div class="user_position"><?php echo classement::get_player_position_daily($row["pt"],$row["user_id"],$quizInfos[0]["date_quiz"]) ?></div>
                                    <div class="user_point"><?php echo $row["pt"]?> <?php echo $this->lang->line('pts') ?></div>
                                </div>

                                <div class="user_name"><?php echo substr($row["first_name"]." ".$row["last_name"],0,15); ?></div>
                            </div>

                                <?php }

                                }
                            }?>
                        </div>
                        <div id="footer_top_day">
                                                    <?php
                        foreach($pagination as $row){
                            echo $row;
                        }
                        ?>
                        </div>
                    </div>
                </div>
                <div id="box"></div>
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
