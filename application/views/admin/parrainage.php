<!DOCTYPE html>
<html lang="fr">
<head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/admin.css" />
        <?php echo $this->xajax->printJavascript(base_url()); ?>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-1.8.11.custom.min.js"></script>

	<title>SwissTv admin</title>
</head>
<body>

    <div id="container">
        <?php echo $this->load->view('admin/partials/top'); ?>
        <?php echo $this->load->view('admin/partials/menu'); ?>
        <div id="content">
            <div id="infos_admin">
                <div id="infos_title">> Points parrainage</div>
                <div id="infos_action">

                </div>
            </div>
            <div id="bloc_left">
                <form name="parrainage_form" id="parrainage_form" method="post" action="">

                    <label>Points :</label>
                    <input type="text" name="pts" id="pts" value="<?php echo $pts[0]["pts"] ?>"><br/><br/>
                    <input type="button" name="valider" value="Modifier" onclick="xajax_parrainage_process(xajax.getFormValues('parrainage_form'))"/>

                </form>
            </div>
        </div>
    </div>

</body>
</html>
