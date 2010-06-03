<div class="span-14">
    <h1 class="float-left">Ver Mas</h1>

    <a href="http://www.addthis.com/bookmark.php?v=20" class="float-right" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()"><img src="http://s7.addthis.com/static/btn/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a>
    <script type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></script>
</div>

<div class="span-14">
    <h3 class="float-left"><?=$info['banda'];?></h3>
    <h3 class="float-right"><?=get_datetime($info['date'], $info['timer']);?></h3>

    <div class="clear">
        <br />
        <div class="float-left">
            <label class="label-form">Genero</label><br />
            <span class="text-medium"><?=$info['genero_name'];?></span>
        </div>

        <fieldset class="fieldset-form-medium float-right">
            <legend>Lugar del Recital</legend>

            <div class="span-7 last">
                <label class="float-left label-form">Nombre</label>
                <span class="float-right"><?=$info['lugar_name'];?></span>
            </div>
            <div class="span-7 last">
                <label class="float-left label-form">Domicilio</label>
                <span class="float-right"><?=$info['lugar_address'];?></span>
            </div>
            <div class="span-7 last">
                <label class="float-left label-form">Provincia</label>
                <span class="float-right"><?=$info['lugar_state'];?></span>
            </div>
            <div class="span-7 last">
                <label class="float-left label-form">Ciudad</label>
                <span class="float-right"><?=$info['lugar_city'];?></span>
            </div>
        </fieldset>
    </div>
    
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

<?php if( $info['lugarvta']->num_rows>0 ) {?>
    <fieldset class="fieldset-form-large float-left">
        <legend>Lugar de ventas de entradas</legend>
        <table id="tblLugaresVta" class="table-lugar" cellpadding="0" cellspacing="0">
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
<?php }?>
    
    <div class="clear">
        <?php if( !empty($info['price']) ){?>
        <p class="float-left">
            <label class="label-form">Precio de entradas anticipadas</label><br />
            <span class="text-medium"><?=$info['price'];?></span>
        </p>
        <?php }?>

        <?php if( !empty($info['price2']) ){?>
        <p class="float-right">
            <label class="label-form">Precio de entradas en puertas</label><br />
            <span class="text-medium"><?=$info['price2'];?></span>
        </p>
        <?php }?>
    </div>
    
    <?php if( !empty($info['moreinfo']) ){?>
    <div class="clear">
        <label class="label-form">M&aacute;s info</label><br />
        <span class="text-medium"><?=$info['moreinfo'];?></span>
    </div>
    <?php }?>
</div>

<script type="text/javascript">
<!--
    $('a.gallery-thumb').fancybox();
-->
</script>