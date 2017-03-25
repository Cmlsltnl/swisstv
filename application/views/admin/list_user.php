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

    <div id="container">
        <?php echo $this->load->view('admin/partials/top'); ?>
        <?php echo $this->load->view('admin/partials/menu'); ?>
        <div id="content">
            <div id="infos_admin">
                <div id="infos_title">> Liste des utilisateurs</div>
                <div id="infos_action"><?php echo anchor("admin/export_csv","Exporter"); ?></div>
            </div>
            <div id="user_table">
                <table>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>E-mail</th>
                    <th>Sexe</th>
                    <th>Langue</th>
                    <!--<th>newsletter</th>
                    <th>SwissTv account</th>-->
                <?php foreach($allUser as $user){ ?>
                    <tr>
                        <td><?php echo $user["first_name"]?></td>
                        <td><?php echo $user["last_name"]?></td>
                        <td><?php echo substr($user["email"],0,50)?></td>
                        <td><?php echo $user["gender"]?></td>
                        <td><?php echo $user["locale"]?></td>
                        <!--<td><?php echo $user["newsletter"]?></td>
                        <td><?php echo $user["swisstv_account"]?></td>-->
                    </tr>

                <?php } ?>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
