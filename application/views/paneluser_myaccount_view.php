<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Music Shows</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <?php include("includes/head_inc.php");?>

    <!--SCRIPT "VALIDADOR DE FORMULARIOS"-->
    <link type="text/css" href="js/jquery.validator/css/style.css" rel="stylesheet"  />
    <script type="text/javascript" src="js/jquery.validator/js/script.min.js"></script>
    <!--END SCRIPT-->

    <script type="text/javascript" src="js/class.account.js"></script>
</head>

<body>
<div id="container">
    <?php include("includes/header_paneluser_inc.php");?>
    <?php include("includes/right_inc.php");?>

<!--inicio contenido-->
    <div id="mainContent">
        <h1>Mi Cuenta</h1>
        <form id="form1" action="<?=site_url('/panel/micuenta/modified/');?>" method="post" class="container-form" enctype="application/x-www-form-urlencoded">
            <div id="mask"></div>

            <!-- =================  DATOS DEL USUARIO  ================ -->
            <h2 class="linetitle">Datos del Usuario</h2>
            <div class="formreg-row">
                <label for="txtUser">Usuario <b>*</b></label><br />
                <input type="text" id="txtUser" name="txtUser" class="inputbox validate" value="<?=$info['username'];?>" />
            </div>
            <div class="formreg-row">
                <label for="txtEmail">E-Mail <b>*</b></label><br />
                <input type="text" id="txtEmail" name="txtEmail" value="<?=$info['email'];?>" class="inputbox validate" onchange="this.value = this.value.toLowerCase();" />
            </div>
            <div class="formreg-row">
                <label for="txtPass">Contrase&ntilde;a <b>*</b></label><br />
                <input type="password" id="txtPass" name="txtPass" class="inputbox validate" />
            </div>
            <div class="formreg-row">
                <label for="txtPass_confirm">Repite Contrase&ntilde;a <b>*</b></label><br />
                <input type="password" id="txtPass_confirm" name="txtPass_confirm" class="inputbox validate" />
            </div>
            <div class="formreg-row">
                <input type="checkbox" name="chkNewsletter" value="1" <?=$info['newsletter']==1 ? 'checked="checked"' : '';?> />&nbsp;Deseo recibir Novedades de Music Shows
            </div>

            <!-- =================  DATOS DEL PERSONALES  ================ -->
            <h2 class="linetitle">Datos Personales</h2>
            <div class="formreg-row">
                <label for="txtLastName">Apellido <b>*</b></label><br />
                <input type="text" id="txtLastName" name="txtLastName" class="inputbox validate" value="<?=$info['lastname'];?>" onchange="$(this).ucTitle();" />
            </div>
            <div class="formreg-row">
                <label for="txtFirstName">Nombre <b>*</b></label><br />
                <input type="text" id="txtFirstName" name="txtFirstName" class="inputbox validate" value="<?=$info['firstname'];?>" onchange="$(this).ucTitle();" />
            </div>
            <div class="formreg-row">
                <label for="cboCountry">Pa&iacute;s <b>*</b></label><br />
                <?=form_dropdown('cboCountry', $listCountry,  $info['country_id'], 'onchange="Account.show_states(this);" class="validate" id="cboCountry"');?>
            </div>
            <div class="formreg-row">
                <label for="cboStates">Provincia <b>*</b></label><br />
                <?=form_dropdown('cboStates', $listStates,  $info['state_id'], 'class="validate" id="cboStates"');?>
            </div>
            <div class="formreg-row">
                <label for="txtCity">Ciudad <b>*</b></label><br />
                <input type="text" id="txtCity" name="txtCity" value="<?=$info['city'];?>" class="inputbox validate" onchange="$(this).ucFirst();" />
            </div>
            <div class="formreg-row">
                <label for="txtPhone">Telefono <b>*</b></label><br />
                <input type="text" id="txtPhoneArea" name="txtPhoneArea" class="inputbox" value="<?=$info['phone_area'];?>" style="width:50px;" />&nbsp;-&nbsp;
                <input type="text" id="txtPhone" name="txtPhone" class="inputbox validate" value="<?=$info['phone'];?>" style="width:200px;" />
            </div>
            <div class="formreg-row">
                <label for="txtAddress">Domicilio</label><br />
                <input type="text" id="txtAddress" name="txtAddress" class="inputbox" value="<?=$info['address'];?>" />
            </div>
            <!-- =================  FIN DATOS PERSONALES ================== -->

            <h4 class="legend">(*) Campos obligatorios</h4>

            <p align="center"><input type="button" value="Modificar" onclick="Account.save();" /></p>
            <input type="hidden" name="user_id" value="<?=$info['user_id'];?>" />
        </form>

        <script type="text/javascript">
        <!--
            Account.initializer();
        -->
        </script>

    </div>
    <br class="clearfloat" />
<!--fin contenido-->
    	
    <?php include("includes/footer_inc.php");?>
  
</div>

</body>
</html>
