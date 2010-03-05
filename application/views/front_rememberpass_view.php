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
    
    <script type="text/javascript" src="js/class.rememberpass.js"></script>
</head>

<body>
<div id="container">
    <?php include("includes/header_inc.php");?>
    <?php include("includes/right_inc.php");?>

<!--inicio contenido-->
    <div id="mainContent">
        <div class="main-container">
            <h1>Recordar Contrase&ntilde;a</h1>

            <form id="form1" action="<?=site_url('/recordarcontrasenia/send/');?>" method="post">
            <?php if( @$status=="ok" ){?>
                <p class="message1">Muy bien, le hemos enviado las instrucciones a su email. Reviselo!</p>
                <p class="message1">Usted puede mantener esta pagina abierta mientras chequea su email. Si usted no recibe las instrucciones en el transcurso de un minuto o dos pruebe <a href="javascript:$('#form1').submit();">Reenviar las instrucciones</a></p>
                <input type="hidden" name="txtField" id="txtField" value="<?=$field;?>" />

            <?php }else{?>

                <p>MusicShows.org le enviara las instrucciones para resetear su contrase&ntilde;a a la direcci&oacute;n de correo asociada a su cuenta.</p>
                <p>Por favor escriba su direcci&oacute;n de <b>email</b> o su <b>usuario</b> a continuaci&oacute;n.</p>

                <div class="formreg-row"><input type="text" name="txtField" id="txtField" class="inputbox validate" /></div>

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
                    <a href="javascript:void($('#imgCaptcha').attr('src', ('<?=site_url('/captcha/index/');?>/'+Math.random()).replace('index.html', 'index')));" tabindex="-1" title="Mostrar otro"><img src="images/refresh.gif" alt="Mostrar otro" border="0" onclick="this.blur()" align="bottom" /></a>
                </div>
                <div class="formreg-row">
                    <input type="text" id="txtCode" name="txtCode" maxlength="6" class="inputbox validate" style="width:225px" />
                </div>


                <input type="button" onclick="RememberPass.send()" value="Enviar" />
            <?php }?>
            </form>
            
            <script type="text/javascript">
            <!--
                RememberPass.initializer();
            -->
            </script>
        </div>
    </div>
    <br class="clearfloat" />
<!--fin contenido-->
    	
    <?php include("includes/footer_inc.php");?>

</div>

</body>
</html>
