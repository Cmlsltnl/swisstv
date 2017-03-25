<div id="title_filleul"><?php echo $this->lang->line('filleul_title') ?></div>
                <div id="nb_filleul">
                        <?php echo $nbFilleul ?> <?php echo $this->lang->line('filleul_sur') ?> <?php echo $nbUser ?> <?php echo $this->lang->line('filleul_participants') ?>
                        , <?php echo date::month(date("Y-m-d"), $this->session->userdata("userLocale"));  ?> = <?php echo $nbParrainage;?> <?php echo $this->lang->line('filleul') ?> = <?php if(!empty($totalPts[0]["pt"])){echo $totalPts[0]["pt"];}else{ echo "0";} ?> <?php echo $this->lang->line('point') ?>
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

            