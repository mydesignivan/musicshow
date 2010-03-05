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
        <div class="anunciantes">

            <h1>Recitales</h1>

            <div class="float-right">
                <input type="button" value="Nuevo" onclick="Recitales.action.New()" />
                <?php if( $listRecitales->num_rows>0 ){?>
                <input type="button" value="Modificar" onclick="Recitales.action.edit()" />
                <input type="button" value="Eliminar" onclick="Recitales.action.del()" />&nbsp;&nbsp;&nbsp;
                <?php }?>
            </div>


            <?php if( $listRecitales->num_rows>0 ){?>
                <div class="tbl-header">
                    <div class="cell-1-3">&nbsp;</div>
                    <div class="cell-6">Banda</div>
                    <div class="cell-7">Lugar</div>
                    <div class="cell-3">Fecha</div>
                </div>

                <div id="tblList" class="tbl-body">
                    <?php foreach( $listRecitales->result_array() as $row ){?>
                        <div class="tbl-body-row">
                            <div class="cell-1-3"><input type="checkbox" value="<?=$row['recital_id'];?>" /></div>
                            <div class="cell-6"><a href="<?=site_url('/recitales/form/'.$row['recital_id']);?>" class="td-name"><?=$row['banda'];?></a></div>
                            <div class="cell-7"><?=$row['place'];?></div>
                            <div class="cell-3"><?=$row['date'];?></div>
                        </div>
                    <?php }?>
                </div>

            <?php }else{?>
            
                <div class="formreg-row"><center><h3>No hay recitales cargados.</h3></center></div>
                
            <?php }?>
        </div>
    </div>
    <br class="clearfloat" />
<!--fin contenido-->
    	
    <?php include("includes/footer_inc.php");?>
  
</div>

</body>
</html>
