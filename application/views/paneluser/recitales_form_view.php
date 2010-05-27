        <?php
            if( is_array($info) ){
                $mode_edit = true;
                $title = "Modificar Recital";
                $action = site_url('/paneluser/recitales/edit/');
                $genero_id = $info['genero_id'];
            }else{
                $mode_edit = false;
                $title = "Nuevo Recital";
                $action = site_url('/paneluser/recitales/create/');
                $genero_id = "0";
            }
        ?>
        <h1><?=$title;?></h1>

        <?php if( $show_form ){?>
        <form id="form1" action="<?=$action;?>" method="post" class="container-form" enctype="multipart/form-data">
            <?php require('application/views/includes/popup_inc.php');?>

            <p>
                <span class="required">*</span><label class="label-form" for="txtBanda">Banda</label><br />
                <input type="text" id="txtBanda" name="txtBanda" class="input-form validate" value="<?=$info['banda'];?>" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="cboGenero">Genero</label><br />
                <?=form_dropdown('cboGenero', $comboGeneros,  $genero_id, 'class="select-form validate" id="cboGenero"');?>
            </p>

            <fieldset class="fieldset-form-medium">
                <legend><span class="required">*</span>Lugar</legend>
                <button type="button" class="button-large" onclick="Recitales.sel_lugar.open(false);">Seleccionar</button><br />

                <div id="msg-validator-lugar" class="prepend-top"></div>

                <div class="span-7 last prepend-top-medium">
                    <label class="float-left label-form">Nombre</label>
                    <input type="text" id="txtPlace" class="float-right input-medium" onkeypress="return false;" value="<?=$info['lugar_name'];?>" />
                </div>
                <div class="span-7 last clear">
                    <label class="float-left label-form">Domicilio</label>
                    <input type="text" id="txtAddress" class="float-right input-medium" onkeypress="return false;" value="<?=$info['lugar_address'];?>" />
                </div>
                <div class="span-7 last clear">
                    <label class="float-left label-form">Provincia</label>
                    <input type="text" id="txtState" class="float-right input-medium" onkeypress="return false;" value="<?=$info['lugar_state'];?>" />
                </div>
                <div class="span-7 last clear">
                    <label class="float-left label-form">Ciudad</label>
                    <input type="text" id="txtCity" class="float-right input-medium" onkeypress="return false;" value="<?=$info['lugar_city'];?>" />
                </div>
            </fieldset>

            <p>
                <span class="required">*</span><label class="label-form" for="txtDate">Fecha</label><br />
                <input type="text" id="txtDate" name="txtDate" class="input-date" value="<?=$info['date'];?>" />
            </p>

            <fieldset class="fieldset-form-large">
                <legend>Lugar de ventas de entradas</legend>
                <button type="button" class="button-large" onclick="Recitales.sel_lugar.open(true);">Seleccionar</button>

                <div id="msg-validator-lugarvta" class="prepend-top"></div>

                <table id="tblLugaresVta" class="table-lugar prepend-top-small <?php if( !$mode_edit ) echo 'hide';?>" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td class="cell-1">Lugar</td>
                            <td class="cell-2">Domicilio</td>
                            <td class="cell-3">Provincia</td>
                            <td class="cell-4">Ciudad</td>
                            <td class="cell-5">Acci&oacute;n</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if( $info['lugarvta'] ){
                        foreach( $info['lugarvta']->result_array() as $row2 ){?>
                            <tr>
                                <td class="cell-1"><?=$row2['lugar_name'];?></td>
                                <td class="cell-2"><?=$row2['lugar_address'];?></td>
                                <td class="cell-3"><?=$row2['lugar_state'];?></td>
                                <td class="cell-4"><?=$row2['lugar_city'];?></td>
                                <td class="cell-5">
                                    <a href="javascript:void(0)" onclick="Recitales.action.lugar_remove(this, <?=$row2['id'];?>)" class="link1">Quitar</a>
                                    <input type="hidden" name="lugarvta_id[]" value="<?=$row2['lugar_id'];?>" />
                                </td>
                            </tr>
                        <?php }
                    }?>
                    </tbody>
                </table>
            </fieldset>

            <div id="msg-validator-images" class="append-bottom"></div>

            <?php if( !$mode_edit ){?>

                <?php for( $n=1; $n<=5; $n++ ){?>
                <div class="append-bottom-small">
                    <div class="span-2"><label class="label-form">Imagen <?=$n?></label></div>
                    <input type="file" class="input-form jq-inputfile" name="fileUpload[]" />
                </div>
                <?php }?>

            <?php }else{?>

                <?php for( $n=1; $n<=5; $n++ ){
                    $prefix = 'image'.$n;
                    $image_full = $info[$prefix.'_full'];
                    $image_thumb = $info[$prefix.'_thumb'];
                ?>

                <div class="span-16 last append-bottom-small">
                    <div class="span-2"><label class="label-form">Imagen <?=$n?></label></div>
                    <?php if( $image_full!='' ){?>
                        <div class="float-left jq-preview"><a href="<?=UPLOAD_DIR.$image_full;?>" rel="group" class="jq-fancybox"><img src="<?=UPLOAD_DIR.$image_thumb;?>" alt="<?=$image_thumb;?>" /></a></div>
                        <div class="float-left margin-left-small">
                            <input type="file" class="input-form float-left" name="fileUpload[]" size="15" onchange="Recitales.events.inputfile_change(this, '<?=$prefix;?>');" />
                            <button type="button" class="button-large float-right" onclick="Recitales.action.del_image(this, '<?=$prefix;?>');">Eliminar</button>
                        </div>
                    <?php }else{?>
                            <input type="file" class="input-form" size="15" name="fileUpload[]" />
                    <?php }?>
                </div>
                <?php }?>

            <?php }?>

            <p class="clear prepend-top"><br />
                <label class="label-form" for="txtPrice">Precio de entradas anticipadas</label><br />
                <input type="text" id="txtPrice" name="txtPrice" class="input-form" value="<?=$info['price'];?>" />
            </p>
            <p>
                <label class="label-form" for="txtPrice2">Precio de entradas en puertas</label><br />
                <input type="text" id="txtPrice2" name="txtPrice2" class="input-form" value="<?=$info['price2'];?>" />
            </p>

            <p class="clear"><br /><label class="label-legend">(*) Campos Obligatorios</label></p>

            <p class="clear span-15 text-center">
                <button type="button" class="button-large" onclick="Recitales.save();">Guardar</button>
            </p>

            <input type="hidden" name="recital_id" value="<?=$info['recital_id'];?>" />
            <input type="hidden" name="lugar_id" value="<?=$info['lugar_id'];?>" />
            <input type="hidden" name="json" />
        </form>
            <div id="tooltip-msg">Si tu ciudad o pueblo no se encuentra, Contactate</div>

        <script type="text/javascript">
        <!--
            Recitales.initializer(<?=$mode_edit ? 'true' : 'false';?>);
        -->
        </script>
        <?php }else{?>

        <div class="notice"><?=$message;?></div>

        <?php }?>