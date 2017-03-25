                        <div id="header_top_day">
                            <h1><?php echo $this->lang->line('resultat_top') ?></h1>
                            <h2><?php if(!empty($quizInfos)){ $tab=explode("-",$quizInfos[0]["date_quiz"]);echo $tab[2]." ".date::month($quizInfos[0]["date_quiz"], $this->session->userdata("userLocale")); } ?></h2>
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

                                <div class="user_name"><?php echo substr($row["first_name"]." ".$row["last_name"],0,15) ?></div>
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