<!-- Facebook Javascript sdk Init function -->
<div id="fb-root"></div>
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
  FB.init({
    appId  : '<?php echo APP_ID?>',
    status : true, // check login status
    cookie : false, // enable cookies to allow the server to access the session
    xfbml  : true  // parse XFBML
  });
  //FB.Canvas.setAutoResize();
  FB.Canvas.setSize({ width: 760, height: 1350 });
</script>
