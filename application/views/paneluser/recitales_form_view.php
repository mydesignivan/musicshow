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
            <?php require('application/views/includes/popup_inc.php');?>

            <p>
                <span class="required">*</span><label class="label-form" for="txtBanda">Banda</label><br />
                <input type="text" id="txtBanda" name="txtBanda" class="input-form validate" value="<?=$info['banda'];?>" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="cboGenero">Genero</label><br />
                <?=form_dropdown('cboGenero', $comboGeneros,  $genero_id, 'class="select-form validate" id="cboGenero"');?>
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="cboStates">Lugar&nbsp;&nbsp;&nbsp;</label>
                <a href="javascript:void(Recitales.sel_lugar());" class="link1">Seleccione un lugar</a><br /><br />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtDate">Fecha</label><br />
                <input type="text" id="txtDate" name="txtDate" class="input-date" value="<?=$info['date'];?>" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtPlace2">Lugar de ventas de entradas</label><br />
                <input type="text" id="txtPlace2" name="txtPlace2" class="input-form validate" value="<?=$info['place2'];?>" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtPrice">Precio de entradas anticipadas</label><br />
                <input type="text" id="txtPrice" name="txtPrice" class="input-form validate" value="<?=$info['price'];?>" />
            </p>
            <p>
                <label class="label-form" for="txtPrice2">Precio de entradas en puertas</label><br />
                <input type="text" id="txtPrice2" name="txtPrice2" class="input-form" value="<?=$info['place2'];?>" />
            </p>

            <p class="clear"><br /><label class="label-legend">(*) Campos Obligatorios</label></p>

            <p class="clear span-15 text-center">
                <button type="button" class="button-large" onclick="Recitales.save();">Guardar</button>
            </p>

            <input type="hidden" name="recital_id" value="<?=$info['recital_id'];?>" />
        </form>

        <div id="container-lugar" class="hide">
            <div class="span-5 border">
                <p><label class="label-form">Provincia:</label></p>
            </div>
            <div class="span-5 last border">
                <p><?=form_dropdown('cboStates', $comboStates,  $info['state_id'], 'class="validate" id="cboStates"');?></p>
            </div>
        </div>

        <script type="text/javascript">
        <!--
            Recitales.initializer();
        -->
        </script>
