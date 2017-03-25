<script type="text/javascript">

 var _gaq = _gaq || [];
 _gaq.push(['_setAccount', 'UA-23612244-1']);
 _gaq.push(['_trackPageview']);

 (function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 })();

</script>
<div id="header">
    <?php
    $annonces=$this->admin_model->get_annonces();
    ?>
    <ul id="ticker01">
        <?php foreach( $annonces as $row ){ ?>
        <li><a href="#"><?php echo $row["annonce_".$this->session->userdata("userLocale")] ?></a></li>
        <?php } ?>
    </ul>
</div>