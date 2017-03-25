                        <div id="header_bloc_right">
                            <a href="#" onclick="xajax_next_month_process('<?php echo $month ?>','<?php echo $year ?>','<?php echo game::PREVIOUS_MONTH ?>','<?php echo game::CATEGORY_ALL ?>')"><div class="button_left"></div></a>
                            <div id="top_month"><?php echo $this->lang->line('classement_top_month');echo date::month(date("Y-".$month."-d"), $this->session->userdata("userLocale")) ?></div>
                            <a href="#" onclick="xajax_next_month_process('<?php echo $month ?>','<?php echo $year ?>','<?php echo game::NEXT_MONTH ?>','<?php echo game::CATEGORY_ALL ?>')"><div class="button_right"></div></a>
                        </div>
                        <div id="content_bloc_right">
                            <?php foreach($classementMonth as $row){ ?>
                            <div class="item_right">
                                <div class="item_right_pos"><?php echo classement::get_player_position_next_month($month,$year,$row["pt"], $row["user_id"]) ?></div>
                                <div class="item_right_img">
                                    <img src="https://graph.facebook.com/<?php echo $row["user_id"] ?>/picture"  />

                                </div>
                                <div class="item_right_name"><?php echo $row["first_name"]." ".$row["last_name"] ?></div>
                                <div class="item_right_pts"><?php echo $row["pt"]?> <?php echo $this->lang->line('pts') ?>
                                <br/>
                                <?php
                                    $parrainage=classement::get_parrainage_month($row["user_id"], $month, $year);
                                    if(!empty($parrainage)){
                                        if(!empty($parrainage[0]["point"])){$nb_parrainage=$parrainage[0]["point"];}else{$nb_parrainage="0";}
                                        echo "<em>(".$nb_parrainage." ".$this->lang->line('pts').")</em>";
                                    }
                                ?>
                                </div>
                                <div class="item_right_prog"></div>
                            </div>
                            <?php } ?>
                        </div>
                        <div id="footer_bloc_right"></div>