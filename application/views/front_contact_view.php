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

    <script type="text/javascript" src="js/class.contact.js"></script>
</head>

<body>
<div id="container">
    <?php include("includes/header_inc.php");?>
    <?php include("includes/right_inc.php");?>

<!--inicio contenido-->
    <div id="mainContent">
        <div class="main-container">
            <h1>Contacto</h1>

            <?php if( $this->session->flashdata('statusmail')=="ok" ){?>
                    <p>Muchas gracias por comunicarse,</p>
                    <p>En breve estaremos en contacto.</p>

            <?php }else{?>
                <form id="form1" action="<?=site_url('/contacto/send');?>" enctype="application/x-www-form-urlencoded" method="post">
                    <div class="formreg-row">
                        <label for="txtName">Nombre Completo: <b>*</b></label><br />
                        <input type="text" name="txtName" id="txtName" class="inputbox validate" />
                    </div>
                    <div class="formreg-row">
                        <label for="txtEmail">Direcci&oacute;n de E-Mail: <b>*</b></label><br />
                        <input type="text" name="txtEmail" id="txtEmail" class="inputbox validate" />
                    </div>
                    <div class="formreg-row">
                        <label for="txtPhone">Telefono:</label><br />
                        <input type="text" name="txtPhone" id="txtPhone" class="inputbox" />
                    </div>
                    <div class="formreg-row">
                        <label for="txtState">Provincia:</label><br />
                        <input type="text" name="txtState" id="txtState" class="inputbox" />
                    </div>
                    <div class="formreg-row">
                        <label for="txtCity">Ciudad:</label><br />
                        <input type="text" name="txtCity" id="txtCity" class="inputbox" />
                    </div>
                    <div class="formreg-row">
                        <label for="txtEmail">Area de Contacto: <b>*</b></label><br />
                        <select name="cboArea" id="cboArea">
                            <option value="ivan@mydesign.com.ar">Area1</option>
                            <option value="ivan@mydesign.com.ar">Area1</option>
                        </select>
                    </div>
                    <div class="formreg-row">
                        <label for="txtConsult">Consulta: <b>*</b></label><br />
                        <textarea name="txtConsult" id="txtConsult" rows="10" cols="80" class="validate"></textarea>
                    </div>

                    <h4>(*) Campos Obligatorios</h4>

                    <p align="center"><input type="button" value="Enviar" onclick="Contact.send();" /></p>
                </form>


                <script type="text/javascript">
                <!--
                    Contact.initializer();
                -->
                </script>

            <?php }?>
        </div>
    </div>
    <br class="clearfloat" />
<!--fin contenido-->

    <?php include("includes/footer_inc.php");?>

</div>

</body>
</html>
