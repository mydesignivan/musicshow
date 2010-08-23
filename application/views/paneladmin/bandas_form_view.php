<h1>Banda</h1>

<!-- ========== NOMBRE BANDA =========== -->
<p>
    <label class="label-form">Nombre banda:&nbsp;</label><span><?=$info['name'];?></span>
</p>
<!-- ========== GENERO =========== -->
<p>
    <label class="label-form">Genero:&nbsp;</label><span><?=$info['genero'];?></span>
</p>
<!-- ========== PROVINCIA =========== -->
<p>
    <label class="label-form">Provincia:&nbsp;</label><span><?=$info['state'];?></span>
</p>
<!-- ========== CIUDAD =========== -->
<p>
    <label class="label-form">Ciudad:&nbsp;</label><span><?=$info['city']?></span>
</p>
<!-- ========== INFLUENCIAS =========== -->
<p>
    <label class="label-form">Influencias:&nbsp;</label><br />
    <?=nl2br($info['influencias'])?>
</p>
<!-- ========== INTEGRANTES =========== -->
<?php if( $info['listIntegrantes']->num_rows>0 ){?>
<div class="clear float-left">
    <label class="label-form">Integrantes</label><br />
    <table class="table-integrantes" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td class="cell-1">Nombre</td>
                <td class="cell-2">Instrumento</td>
            </tr>
        </thead>
        <tbody>
        <?php $listIntegrantes = $info['listIntegrantes']->result_array();?>
        <?php foreach( $listIntegrantes as $rowInt ){?>
            <tr>
                <td class="cell-1"><?=$rowInt['name']?></td>
                <td class="cell-2"><?=$rowInt['instrument']?></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
<?php }?>

<!-- ========== IMAGENES =========== -->
<div class="clear float-left prepend-top">
    <label class="label-form">Im&aacute;genes</label><br />

    <table class="table-gallerybanda" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td class="cell-1">Im&aacute;gen</td>
                <td class="cell-2">Comentario</td>
            </tr>
        </thead>
        <tbody>
    <?php $listImages = $info['listImages']->result_array()?>
    <?php foreach( $listImages as $rowImage ){?>
            <tr>
                <td class="cell-1"><a href="<?=UPLOAD_BANDA_DIR . $rowImage['image']?>" class="jq-thumb"><img src="<?=UPLOAD_BANDA_DIR . $rowImage['thumb']?>" alt="<?=$rowImage['thumb']?>" width="<?=$rowImage['width']?>" height="<?=$rowImage['height']?>" /></a></td>
                <td class="cell-2"><?=nl2br($rowImage['comment'])?></td>
            </tr>
    <?php }?>
        </tbody>
    </table>
</div>

<!-- ========== DISCOGRAFICA =========== -->
<?php if( $info['discografica_visible']==1 ){?>
<div class="float-left clear prepend-top">
    <label class="label-form">Discogr&aacute;fica Actual:&nbsp;</label><span><?=$info['discografica_actual']?></span>
</div>
<?php }?>

<?php if( isset($info['listDisc']) && count($info['listDisc'])>0 ){?>
<div class="clear float-left prepend-top">
    <label class="label-form">Discogr&aacute;fica</label><br />
    <table class="table-discografica" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td class="cell-1">Nombre CD</td>
                <td class="cell-2">Discogr&aacute;fica</td>
                <td class="cell-3">Temas</td>
                <td class="cell-4">Tapa del CD</td>
            </tr>
        </thead>
        <tbody>
   <?php $listDisc = $info['listDisc'];?>
   <?php foreach( $listDisc as $rowDisc ) {?>
            <tr>
                <td class="cell-1"><?=$rowDisc['cd_name']?></td>
                <td class="cell-2"><?=$rowDisc['discografia']?></td>
                <td class="cell-3">
                    <table class="table-temas-discografica" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <td class="cell1">Nombre</td>
                                <td class="cell2">Minutos</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach( $rowDisc['tracks'] as $rowTrack ){?>
                            <tr>
                                <td class="cell1"><?=$rowTrack['name']?></td>
                                <td class="cell2"><?=$rowTrack['minutes']?></td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </td>
                <td class="cell-4">
                    <?php if( !empty($rowDisc['thumb']) ){?>
                    <a href="<?=UPLOAD_DISC_DIR . $rowDisc['image']?>" class="jq-thumb"><img src="<?=UPLOAD_DISC_DIR . $rowDisc['thumb']?>" alt="<?=$rowDisc['thumb']?>" width="<?=$rowDisc['width']?>" height="<?=$rowDisc['height']?>" /></a>
                    <?php }?>
                </td>
            </tr>
    <?php }?>
        </tbody>
    </table>
</div>
<?php }?>

<!-- ========== HISTORIA DE LA BANDA =========== -->
<div class="clear float-left prepend-top">
    <label class="label-form">Historia de la Banda:</label><br />
    <?=nl2br($info['history'])?>
</div>

<!-- ========== TOCANDO DESDE =========== -->
<div class="clear float-left">
    <label class="label-form">Tocando Desde:&nbsp;</label><span><?=$info['tocando_desde'];?></span>
</div>

<!-- ========== MANAGER =========== -->
<?php if( $info['manager_visible']==1 ){?>
<div class="clear float-left prepend-top">
    <div class="span-10">
        <label class="label-form float-left">Nombre:&nbsp;</label>
        <span><?=$info['manager_name'];?></span>
    </div>
    <div class="clear span-10">
        <label class="label-form float-left">Telefono:&nbsp;</label>
        <span><?=$info['manager_phone'];?></span>
    </div>
    <div class="clear span-10">
        <label class="label-form float-left">E-Mail:&nbsp;</label>
        <span><?=$info['manager_mail'];?></span>
    </div>
</div>
<?php }?>

<!-- ========== CONTACTO DE PRENSA =========== -->
<div class="clear float-left">
    <label class="label-form">Contacto de Prensa:&nbsp;</label>
</div>

<div class="clear float-left">
    <div class="span-10">
        <label class="label-form float-left">Nombre:&nbsp;</label>
        <span><?=$info['contact_name'];?></span>
    </div>
    <div class="clear span-10">
        <label class="label-form float-left">Telefono:&nbsp;</label>
        <span><?=$info['contact_phone'];?></span>
    </div>
    <div class="clear span-10">
        <label class="label-form float-left">E-Mail:&nbsp;</label>
        <span><?=$info['contact_mail'];?></span>
    </div>
</div>

<!-- ========== OTROS CONTACTOS =========== -->
<div class="clear float-left">
    <label class="label-form">Otros Contactos:</label>
</div>

<?php if( isset($info['listOtherContact']) && $info['listOtherContact']->num_rows>0 ){?>
<div class="clear float-left">
    <table class="table-othercontact" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td class="cell-1">Nombre</td>
                <td class="cell-2">Telefono</td>
                <td class="cell-3">E-Mail</td>
            </tr>
        </thead>
        <tbody>
    <?php $listOtherContact = $info['listOtherContact']->result_array();?>
    <?php foreach( $listOtherContact as $rowOC ) {?>
            <tr>
                <td class="cell-1"><?=$rowOC['name']?></td>
                <td class="cell-2"><?=$rowOC['phone']?></td>
                <td class="cell-3"><?=$rowOC['email']?></td>
            </tr>
    <?php }?>
        </tbody>
    </table>
</div>
<?php }?>

<!-- ========== LA BANDA EN LA WEB =========== -->
<div class="clear float-left">
    <label class="label-form">La banda en la Web:</label>
</div>

<?php if( isset($info['listWebLink']) && $info['listWebLink']->num_rows>0 ){?>
<div class="clear float-left">
    <table class="table-bandaweb" cellpadding="0" cellspacing="0">
        <tbody>
    <?php $listWebLink = $info['listWebLink']->result_array();?>
    <?php foreach( $listWebLink as $rowWL ) {?>
            <tr>
                <td class="cell-1"><?=($rowWL['title']=="other") ? $rowWL['title_other'] : $rowWL['title']?></td>
                <td class="cell-2"><?=$rowWL['url']?></td>
            </tr>
    <?php }?>
        </tbody>
    </table>
</div>
<?php }?>

<!-- ========== LINKS DE INTERES =========== -->
<?php if( isset($info['listLinksInteres']) && $info['listLinksInteres']->num_rows>0 ){?>
<div class="clear prepend-top float-left">
    <label class="label-form">Links de Interes:</label><br />
    <table class="table-integrantes" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td class="cell-1">T&iacute;tulo</td>
                <td class="cell-2">URL</td>
            </tr>
        </thead>
        <tbody>
        <?php $listLinksInteres = $info['listLinksInteres']->result_array();?>
        <?php foreach( $listLinksInteres as $row ){?>
            <tr>
                <td class="cell-1"><?=$row['title']?></td>
                <td class="cell-2"><?=$row['url']?></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
<?php }?>

<!-- ========== MAS INFO =========== -->
<div class="clear float-left prepend-top">
    <label class="label-form">Mas Info:</label><br />
    <?=nl2br($info['masinfo'])?>
</div>
