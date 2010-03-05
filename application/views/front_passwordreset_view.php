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

            <?php if( @$status=="ok" ){?>
                <form id="form3" action="<?=site_url('/login/account_access/');?>" method="post">
                    <p>
                        Muy Bien! Su contrase&ntilde;a ha sido cambiada!<br />
                        Por favor asegurese de memorizarla o anotarla en un lugar seguro.
                    </p>

                    <input type="submit" value="Acceder a su cuenta" />
                    <input type="hidden" name="p1" value="<?=$data['username'];?>" />
                    <input type="hidden" name="p2" value="<?=$data['password'];?>" />
                </form>

            <?php }else{?>

                <form id="form2" action="<?=site_url('/recordarcontrasenia/send_newpass/'.$this->uri->segment(3)."/".$this->uri->segment(4));?>" method="post">

                    <p>
                        Cambie su Contrase&ntilde;a<br />
                        Por favor, elija una contrase&ntilde;a para usar con su cuenta de MusicShows.com.ar
                    </p>
                    <div class="formreg-row">
                        <label for="txtPass" class="cell-6">Nueva Contrase&ntilde;a</label>&nbsp;&nbsp;
                        <input type="password" name="txtPass" id="txtPass" class="inputbox validate" />
                    </div>
                    <div class="formreg-row">
                        <label for="txtPass" class="cell-6">Verifique Nueva Contrase&ntilde;a</label>&nbsp;&nbsp;
                        <input type="password" name="txtPass_confirm" id="txtPass_confirm" class="inputbox validate" />
                    </div>

                    <input type="button" onclick="RememberPass.send2()" value="Enviar" />
                    <input type="hidden" name="usr" value="<?=@$username;?>" />
                    <input type="hidden" name="token" value="<?=@$token;?>" />
                </form>
            <?php }?>

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
