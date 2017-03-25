<div id="footer">
    <div id="logo"></div>
    <div id="result_footer"><?php //echo $this->lang->line('footer_result') ?></div>
    <div id="contact"><?php //echo anchor("",$this->lang->line('footer_contact'));?></div>
    <div id="reglement"><a href="<?php  echo base_url() ?>uploads/reglement_<?php echo $this->session->userdata("userLocale") ?>.pdf" target="_blank"><?php echo $this->lang->line('footer_reglement') ?></a></div>
    <div id="fr"><?php echo anchor("game/index/fr",$this->lang->line('footer_fr'));?></div>
    <div id="de"><?php echo anchor("game/index/de",$this->lang->line('footer_de'));?></div>
</div>