<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Music Shows</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <?php include("includes/head_inc.php");?>

    <script type="text/javascript" src="js/class.recitales.js"></script>
</head>

<body>
<div id="container">
    <?php include("includes/header_paneluser_inc.php");?>
    <?php include("includes/right_inc.php");?>

<!--inicio contenido-->
    <div id="mainContent">
        <h1>Recitales</h1>


        <p>
            <input type="button" value="Nuevo" onclick="location.href='<?=site_url('/recitales/form')?>'" />
            <input type="button" value="Modificar" onclick="Recitales.action.edit()" />
            <input type="button" value="Eliminar" onclick="Recitales.action.del()" />
        </p>

        

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
