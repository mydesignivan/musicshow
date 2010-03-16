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

    <!--SCRIPT: "CALENDARIO DatePicker"-->
    <link rel="stylesheet" href="js/jquery.datepicker/style.css" type="text/css" media="all" />
    <script type="text/javascript" src="js/jquery.datepicker/ui.datepicker.min.js"></script>
    <!--END SCRIPT-->

    <script type="text/javascript" src="js/class.recitales.js"></script>
</head>

<body>
<div id="container">
    <?php include("includes/header_paneluser_inc.php");?>
    <?php include("includes/right_inc.php");?>

<!--inicio contenido-->
    <div id="mainContent">
        <?php
            if( is_array($info) ){
                $title = "Modificar Recital";
                $action = site_url('/panel/recitales/edit/');
                $genero_id = $info['genero_id'];
            }else{
                $title = "Nuevo Recital";
                $action = site_url('/panel/recitales/save/');
                $genero_id = "0";
            }
        ?>

        <h1><?=$title;?></h1>

        <form id="form1" action="<?=$action;?>" method="post" class="container-form" enctype="application/x-www-form-urlencoded">
            <div id="mask"></div>

            <div class="formreg-row">
                <label for="txtBanda">Banda <b>*</b></label><br />
                <input type="text" id="txtBanda" name="txtBanda" class="inputbox validate" value="<?=$info['banda'];?>" />
            </div>
            <div class="formreg-row">
                <label for="cboGenero">Genero <b>*</b></label><br />
                <?=form_dropdown('cboGenero', $listGeneros,  $genero_id, 'class="validate" id="cboGenero"');?>
            </div>
            <div class="formreg-row">
                <label for="txtPlace">Lugar <b>*</b></label><br />
                <input type="text" id="txtPlace" name="txtPlace" class="inputbox validate" value="<?=$info['place'];?>" />
            </div>
            <div class="formreg-row">
                <label for="txtDate">Fecha <b>*</b></label><br />
                <input type="text" id="txtDate" name="txtDate" class="inputbox" value="<?=$info['date'];?>" style="width:105px;" />
            </div>
            <div class="formreg-row">
                <label for="txtPlace2">Lugar de ventas de entradas <b>*</b></label><br />
                <input type="text" id="txtPlace2" name="txtPlace2" class="inputbox validate" value="<?=$info['place2'];?>" />
            </div>
            <div class="formreg-row">
                <label for="txtPrice">Precio de entradas anticipadas <b>*</b></label><br />
                <input type="text" id="txtPrice" name="txtPrice" class="inputbox validate" value="<?=$info['price'];?>" />
            </div>
            <div class="formreg-row">
                <label for="txtPrice2">Precio de entradas en puertas</label><br />
                <input type="text" id="txtPrice2" name="txtPrice2" class="inputbox" value="<?=$info['place2'];?>" />
            </div>

            <h4 class="legend">(*) Campos obligatorios</h4>

            <p align="center">
                <input type="button" value="Guardar" onclick="Recitales.save();" />
            </p>
            <input type="hidden" name="recital_id" value="<?=$info['recital_id'];?>" />
        </form>

        <script type="text/javascript">
        <!--
            Recitales.initializer();
        -->
        </script>

    </div>
    <br class="clearfloat" />
<!--fin contenido-->
    	
    <?php include("includes/footer_inc.php");?>
  
</div>

</body>
</html>