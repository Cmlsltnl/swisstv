                        <div id="header_bloc_left">
                            <a href="#" onclick="xajax_next_week_process('<?php echo $week ?>','<?php echo $year ?>','<?php echo game::PREVIOUS_WEEK ?>','<?php echo game::CATEGORY_ALL ?>','<?php echo game::CATEGORY_FRIENDS ?>')"><div class="button_left"></div></a>
                            <div id="top_week"><?php echo $this->lang->line('classement_top_week');echo $week; ?></div>
                            <a href="#" onclick="xajax_next_week_process('<?php echo $week ?>','<?php echo $year ?>','<?php echo game::NEXT_WEEK ?>','<?php echo game::CATEGORY_ALL ?>','<?php echo game::CATEGORY_FRIENDS ?>')"><div class="button_right"></div></a>
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
                                <div class="item_left_pts"><?php echo $row["pt"]?> <?php echo $this->lang->line('pts') ?></div>
                                <div class="item_left_prog"></div>
                            </div>
                            <?php } ?>
                        </div>
                        <div id="footer_bloc_left"></div>
