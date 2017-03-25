<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/admin.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/uniform.default.css" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/admin.js"></script>

	<title>SwissTv admin</title>
</head>
<body>

    <div id="container_login">
        <div id="login">
            <div id="login_header">Identification SwissTv</div>
            <?php
            $attributes = array('id' => 'connexion');
            echo form_open('admin/check', $attributes);?>
                <label>Email</label><br/>
                <input type="text" name="email" value="" /><br/><br/>
                <label>Password</label><br/>
                <input type="password" name="password" value="" /><br/><br/>
                <input type="submit" name="login" value="Connexion"/>
            </form>
        </div>
    </div>

</body>
</html>
