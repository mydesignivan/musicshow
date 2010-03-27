        <h1>Detalle Recital</h1>

        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Usuario</label></div>
            <span class="text-medium"><?=$info['username'];?></span>
        </div>
        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Banda</label></div>
            <span class="text-medium"><?=$info['banda'];?></span>
        </div>

        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Genero</label></div>
            <span class="text-medium"><?=$info['genero_name'];?></span>
        </div>
        
        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Fecha</label></div>
            <span class="text-medium"><?=$info['date'];?></span>
        </div>

        <fieldset class="fieldset-form-medium">
            <legend>Lugar</legend>
            <div class="append-bottom-small">
                <div class="span-4"><label class="label-form">Nombre</label></div>
                <span class="text-medium"><?=$info['lugar_name'];?></span>
            </div>
            <div class="append-bottom-small">
                <div class="span-4"><label class="float-left label-form">Domicilio</label></div>
                <span class="text-medium"><?=$info['lugar_address'];?></span>
            </div>
            <div class="append-bottom-small">
                <div class="span-4"><label class="float-left label-form">Provincia</label></div>
                <span class="text-medium"><?=$info['lugar_state'];?></span>
            </div>
            <div class="append-bottom-small">
                <div class="span-4"><label class="float-left label-form">Ciudad</label></div>
                <span class="text-medium"><?=$info['lugar_city'];?></span>
            </div>
        </fieldset>

        <fieldset class="fieldset-form-large prepend-top">
            <legend>Lugar de ventas de entradas</legend>
            <table id="tblLugaresVta" class="table-lugar prepend-top-small" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td class="cell-1">Lugar</td>
                        <td class="cell-2">Domicilio</td>
                        <td class="cell-3">Provincia</td>
                        <td class="cell-4">Ciudad</td>
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
                        </tr>
                    <?php }
                }?>
                </tbody>
            </table>
        </fieldset>

        <fieldset class="gallery">
            <legend>Galer&iacute;a de Im&aacute;genes</legend>

            <?php for( $n=1; $n<=5; $n++ ){
                $image_thumb = $info["image".$n."_thumb"];
                $image_full = $info["image".$n."_full"];
                if( !empty($image_thumb) ){
            ?>
                <a href="<?=UPLOAD_DIR.$image_full;?>" class="gallery-thumb" rel="group"><img src="<?=UPLOAD_DIR.$image_thumb;?>" alt="<?=$image_thumb;?>" /></a>
            <?php }}?>
        </fieldset>
        
        <?php if( !empty($info['price']) ){?>
        <div class="append-bottom-small">
            <div class="span-6"><label class="label-form">Precio de entradas anticipadas</label></div>
            <span class="text-medium"><?=$info['price'];?></span>
        </div>
        <?php }?>

        <?php if( !empty($info['price2']) ){?>
        <div class="append-bottom-small">
            <div class="span-6"><label class="label-form">Precio de entradas en puertas</label></div>
            <span class="text-medium"><?=$info['price2'];?></span>
        </div>
        <?php }?>

        <div class="clear prepend-top text-center">
            <button type="button" class="button-medium" onclick="location.href='<?=site_url('/paneladmin/recitales/index/'.$this->uri->segment(5));?>';">Volver</button>
        </div>
        