<?php $estate=$this->uri->segment(3); ?>
<div id="menu">
    <div id="menu_home" ><div <?php if(empty($estate) || $estate==1){ ?>class="rollover" <?php } ?>><?php echo anchor("game/index/1","<div id='home'></div>");?> <div class="separator"></div></div></div>
    <div id="menu_infos"><div <?php if($estate && $estate==2){ ?>class="rollover" <?php } ?>><?php echo anchor("game/mission/2",$this->lang->line('menu_infos'));?><div class="separator"></div></div></div>
    <div id="menu_cadeaux"><div <?php if($estate && $estate==3){ ?>class="rollover" <?php } ?>><?php echo anchor("game/cadeaux/3",$this->lang->line('menu_cadeaux'));?><div class="separator"></div></div></div>
    <div id="menu_resultats"><div <?php if($estate && $estate==4){ ?>class="rollover" <?php } ?>><?php echo anchor("game/resultat/4",$this->lang->line('menu_resultats'));?><div class="separator"></div></div></div>
    <div id="menu_classement"><div <?php if($estate && $estate==5){ ?>class="rollover" <?php } ?>><?php echo anchor("game/classement/5",$this->lang->line('menu_classements'));?><div class="separator"></div></div></div>
    <div id="menu_filleuls"><div <?php if($estate && $estate==6){ ?>class="rollover" <?php } ?>><?php echo anchor("game/filleul/6",$this->lang->line('menu_filleuls'));?><div class="separator"></div></div></div>
    <div id="menu_mon_compte"><div <?php if($estate && $estate==7){ ?>class="rollover" <?php } ?>><?php echo anchor("game/mon_compte/7",$this->lang->line('menu_mon_compte'));?></div></div>
</div>