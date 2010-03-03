<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Music Shows</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <?php include("includes/head_inc.php");?>
</head>

<body>
<div id="container">
    <?php include("includes/header_inc.php");?>
    <?php include("includes/right_inc.php");?>

<!--inicio contenido-->
    <div id="mainContent">
        <form id="form1" action="" method="post" class="container-form" enctype="application/x-www-form-urlencoded">

            <!-- =================  DATOS DEL USUARIO  ================ -->
            <h2 class="linetitle">Datos del Usuario</h2>
            <div class="formreg-row">
                <label for="txtEmail">E-Mail <b>*</b></label><br />
                <input type="text" id="txtEmail" name="txtEmail" class="inputbox" />
            </div>
            <div class="formreg-row">
                <label for="txtEmail_confirm">Repite tu E-Mail <b>*</b></label><br />
                <input type="text" id="txtEmail_confirm" name="txtEmail_confirm" class="inputbox" />
            </div>
            <div class="formreg-row">
                <label for="txtPass">Contrase&ntilde;a <b>*</b></label><br />
                <input type="password" id="txtPass" name="txtPass" class="inputbox" />
            </div>
            <div class="formreg-row">
                <label for="txtPass">Repite Contrase&ntilde;a <b>*</b></label><br />
                <input type="password" id="txtPass_confirm" name="txtPass_confirm" class="inputbox" />
            </div>
            <div class="formreg-row">
                <input type="checkbox" name="chkNewsletter" />&nbsp;Deseo recibir Novedades de Music Shows
            </div>

            <!-- =================  DATOS DEL PERSONALES  ================ -->
            <h2 class="linetitle">Datos Personales</h2>
            <div class="formreg-row">
                <label for="txtLastName">Apellido <b>*</b></label><br />
                <input type="text" id="txtLastName" name="txtLastName" class="inputbox" />
            </div>
            <div class="formreg-row">
                <label for="txtFirstName">Nombre <b>*</b></label><br />
                <input type="text" id="txtFirstName" name="txtFirstName" class="inputbox" />
            </div>
            <div class="formreg-row">
                <label for="cboCountry">Pa&iacute;s <b>*</b></label><br />
                <?=form_dropdown('cboCountry', $listCountry, '0');?>
            </div>
            <div class="formreg-row">
                <label for="txtFirstName">Provincia <b>*</b></label><br />
                <select><option value="0">Seleccione un Pa&iacute;s</option></select>
            </div>
            <div class="formreg-row">
                <label for="txtCity">Ciudad <b>*</b></label><br />
                <input type="text" id="txtCity" name="txtCity" class="inputbox" />
            </div>
            <div class="formreg-row">
                <label for="txtPhone">Telefono <b>*</b></label><br />
                <input type="text" id="txtPhoneArea" name="txtPhoneArea" class="inputbox" style="width:50px;" />&nbsp;-&nbsp;
                <input type="text" id="txtPhone" name="txtPhone" class="inputbox" style="width:200px;" />
            </div>
            <div class="formreg-row">
                <label for="txtAddress">Domicilio <b>*</b></label><br />
                <input type="text" id="txtAddress" name="txtAddress" class="inputbox" />
            </div>
            <div class="formreg-row">
                <label for="txtCode">Ingrese el c&oacute;digo de abajo <b>*</b></label><br />
                <img id="imgCaptcha" src="<?=site_url('/captcha/index/'.md5(time()));?>" align="left" border="1" alt="" style="margin-right:5px;" />

                <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="19" height="19" id="SecurImage_as3" align="middle">
                    <param name="allowScriptAccess" value="sameDomain" />
                    <param name="allowFullScreen" value="false" />
                    <param name="movie" value="images/securimage_play.swf?audio=<?=site_url('/captcha/play/');?>&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
                    <param name="quality" value="high" />
                    <param name="bgcolor" value="#ffffff" />
                    <embed src="images/securimage_play.swf?audio=<?=site_url('/captcha/play/');?>&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" quality="high" bgcolor="#ffffff" width="19" height="19" name="SecurImage_as3" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
                </object>
                <br />
                <a href="javascript:void($('#imgCaptcha').attr('src', '<?=site_url('/captcha/index/');?>/'+Math.random()));" tabindex="-1" title="Mostrar otro"><img src="images/refresh.gif" alt="Mostrar otro" border="0" onclick="this.blur()" align="bottom" /></a>
            </div>
            <div class="formreg-row">
                <input type="text" id="txtCode" name="txtCode" class="inputbox" style="width:225px" />
            </div>

            <br class="clearfloat" />
            <p align="center"><input type="button" value="Registrarme" /></p>
        </form>
    </div>
    <br class="clearfloat" />
<!--fin contenido-->
    	
    <?php include("includes/footer_inc.php");?>
  
</div>

</body>
</html>
