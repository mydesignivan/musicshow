        <h1><?=$title;?></h1>

        <?php if( $this->session->flashdata('status')!='' ){?>
        <div class="<?=$this->session->flashdata('status')?>">
            <?=$this->session->flashdata('message')?>
        </div>
        <?php }?>

        <form id="form1" action="<?=site_url(!$info ? '/paneluser/bandas/create/' : '/paneluser/bandas/edit/');?>" method="post" class="container-form" enctype="multipart/form-data">
            <?php require('application/views/includes/popup_inc.php');?>

            <!-- ========== NOMBRE BANDA =========== -->
            <p>
                <span class="required">*</span><label class="label-form" for="txtBanda">Nombre banda</label><br />
                <input type="text" id="txtBanda" name="txtBanda" class="input-form" value="<?=$info['name'];?>" />
            </p>
            <!-- ========== GENERO =========== -->
            <p>
                <span class="required">*</span><label class="label-form" for="txtGenero">Genero</label><br />
                <input type="text" id="txtGenero" name="txtGenero" class="input-form" value="<?=$info['genero'];?>" />
            </p>
            <!-- ========== PROVINCIA =========== -->
            <p>
                <span class="required">*</span><label class="label-form" for="cboStates">Provincia</label><br />
                <?=form_dropdown('cboStates', $comboStates,  @$info['state_id'], 'class="select-form" id="cboStates" onchange="Bandas.show_states(this)"');?>
            </p>
            <!-- ========== CIUDAD =========== -->
            <p>
                <span class="required">*</span><label class="label-form" for="cboCity">Ciudad</label><br />
                <?php
                if( isset($info['comboCity']) ) {
                    echo form_dropdown('cboCity', $info['comboCity'],  @$info['city_id'], 'class="select-form" id="cboCity"');
                }else{?>
                    <select name="cboCity" id="cboCity" class="select-form">
                        <option value="">Seleccione una Provincia</option>
                    </select>
            <?php }?>
            </p>
            <!-- ========== INFLUENCIAS =========== -->
            <p>
                <label class="label-form" for="txtInfluencias">Influencias</label><br />
                <textarea name="txtInfluencias" id="txtInfluencias" cols="22" rows="5" class="textarea-form"><?=$info['influencias']?></textarea>
            </p>

            <!-- ========== INTEGRANTES =========== -->
            <div class="clear float-left">
                <span class="required">*</span><label class="label-form">Integrantes</label><br />
                <table id="tblIntegrantes" class="table-integrantes" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td class="cell-1">Nombre</td>
                            <td class="cell-2">Instrumento</td>
                            <td class="cell-3">Acci&oacute;n</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $listIntegrantes = array();
                    $listIntegrantes[] = array('name'=>'', 'instrument'=>'');
                    if( isset($info['listIntegrantes']) ){
                        if( $info['listIntegrantes']->num_rows>0 )
                            $listIntegrantes = $info['listIntegrantes']->result_array();
                    }
                    ?>
                    <?php foreach( $listIntegrantes as $rowInt ){?>
                        <tr>
                            <td class="cell-1"><input type="text" class="input-table" name="txtIntegName[]" value="<?=$rowInt['name']?>" /></td>
                            <td class="cell-2"><input type="text" class="input-table" name="txtIntegInstr[]" value="<?=$rowInt['instrument']?>" /></td>
                            <td class="cell-3"><button type="button" name="btnintdel" class="button-medium" onclick="JTable.remove(this)">Eliminar</button></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <button type="button" name="btnintadd" class="button-large" onclick="JTable.add('#tblIntegrantes')">Agregar otro</button>
                <div id="msgbox-integrantes" class="hide clear prepend-top error"></div>
            </div>

            <!-- ========== IMAGENES =========== -->
            <div class="clear float-left prepend-top">
                <span class="required">*</span><label class="label-form">Im&aacute;genes</label><br />

                <table id="tblImagesBandas" class="table-gallerybanda" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td class="cell-1">Im&aacute;gen</td>
                            <td class="cell-2">Comentario</td>
                            <td class="cell-3">Acci&oacute;n</td>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                    $listImages = array();
                    if( !isset($info['listImages']) ){
                        $listImages[] = array('bandagallerie_id'=>0, 'thumb'=>'', 'width'=>'', 'height'=>'', 'comment'=>'');
                    }else{
                        $listImages = $info['listImages']->result_array();
                    }?>

                <?php foreach( $listImages as $rowImage ){?>
                        <tr <?php if( $rowImage['bandagallerie_id']!=0 ) echo 'id="image'.$rowImage['bandagallerie_id'].'"'?>>
                            <td class="cell-1">
                            <?php if( !empty($rowImage['thumb']) ){?>
                                <a href="<?=UPLOAD_BANDA_DIR . $rowImage['image']?>" class="jq-thumb"><img src="<?=UPLOAD_BANDA_DIR . $rowImage['thumb']?>" alt="<?=$rowImage['thumb']?>" width="<?=$rowImage['width']?>" height="<?=$rowImage['height']?>" /></a><br />
                            <?php }?>
                                    <input type="file" name="<?=$rowImage['bandagallerie_id']==0 ? 'txtImage[]' : 'txtImageEdit[]';?>" size="10" />
                                    <?php if( $rowImage['bandagallerie_id']!=0 ){?><input type="hidden" name="id_imagebanda[]" value="<?=$rowImage['bandagallerie_id']?>" /><?php }?>
                            </td>
                            <td class="cell-2"><textarea name="<?=$rowImage['bandagallerie_id']==0 ? 'txtImageComment[]' : 'txtImageCommentEdit[]';?>" cols="22" rows="5" class="textarea-small"><?=$rowImage['comment']?></textarea></td>
                            <td class="cell-3"><button type="button" name="btnimg" class="button-medium" onclick="Bandas.removeImage(this)">Eliminar</button></td>
                        </tr>
                <?php }?>
                    </tbody>
                </table>
                <button type="button" class="button-large" name="btndiscadd" onclick="Bandas.addImage(this)">Agregar otro</button>
                <div id="msgbox-image" class="hide clear prepend-top error"></div>
            </div>

            <!-- ========== DISCOGRAFICA =========== -->
            <div class="float-left clear prepend-top">
                <label class="label-form" for="optDiscografia">Discogr&aacute;fica</label>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;Si</span><input type="radio" name="optDiscografia" onclick="Bandas.showhide_discografica('show');" value="1" <?php if( $info['discografica_visible']==1 ) echo 'checked="checked"';?> />&nbsp;&nbsp;
                <span>No</span><input type="radio" name="optDiscografia"  onclick="Bandas.showhide_discografica('hide');" value="0" <?php if( !isset($info['discografica_visible']) || $info['discografica_visible']==0 ) echo 'checked="checked"';?> />
            </div>

            <div id="div1" class="float-left clear prepend-top <?php if( $info['discografica_visible']!=1 ) echo 'hide';?>">
                <label class="label-form" for="txtDiscActual">Discogr&aacute;fica Actual</label>&nbsp;
                <input type="text" id="txtDiscActual" name="txtDiscActual" class="input-form" value="<?=$info['discografica_actual']?>" />
            </div>

            <div id="contDiscografica" class="clear float-left prepend-top">
                <label class="label-form">Discogr&aacute;fica</label><br />
                <table id="tblDiscografica" class="table-discografica" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td class="cell-1">Nombre CD</td>
                            <td class="cell-2">Discogr&aacute;fica</td>
                            <td class="cell-3">Temas</td>
                            <td class="cell-4">Tapa del CD</td>
                            <td class="cell-5">Acci&oacute;n</td>
                        </tr>
                    </thead>
                    <tbody>
               <?php
                $listDisc = array();
                $listDisc[] = array('discografica_id'=>0, 'discografia'=>'', 'cd_name'=>'', 'thumb'=>'', 'width'=>'', 'height'=>'', 'tracks'=>array(array('tema_id'=>0, 'name'=>'', 'minutes'=>'')));
                if( isset($info['listDisc']) && count($info['listDisc'])>0 ){
                    $listDisc = $info['listDisc'];
                }?>
                <?php foreach( $listDisc as $rowDisc ) {?>
                        <tr <?php if( $rowDisc['discografica_id']!=0 ) echo 'id="disc'.$rowDisc['discografica_id'].'"'?>>
                            <td class="cell-1"><input type="text" class="input-table" name="txtDiscCDname<?=$rowDisc['discografica_id']!=0 ? 'Edit' : ''?>[]" value="<?=$rowDisc['cd_name']?>" /></td>
                            <td class="cell-2"><input type="text" class="input-table" name="txtDiscName<?=$rowDisc['discografica_id']!=0 ? 'Edit' : ''?>[]" value="<?=$rowDisc['discografia']?>" /></td>
                            <td class="cell-3">
                                <table class="table-temas-discografica" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td class="cell1">Nombre</td>
                                            <td class="cell2">Minutos</td>
                                            <td class="cell3">Acci&oacute;n</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach( $rowDisc['tracks'] as $rowTrack ){?>
                                        <tr <?php if( $rowTrack['tema_id']!=0 ) echo 'id="track'.$rowTrack['tema_id'].'"'?>>
                                            <td class="cell1"><input type="text" name="txtTrackName<?=$rowTrack['tema_id']!=0 ? 'Edit' : ''?>" class="input-table" value="<?=$rowTrack['name']?>" /></td>
                                            <td class="cell2"><input type="text" name="txtTrackMin<?=$rowTrack['tema_id']!=0 ? 'Edit' : ''?>" class="input-table jq-field-int" value="<?=$rowTrack['minutes']?>" /></td>
                                            <td class="cell3"><button type="button" name="btndiscdeltrack" class="button-medium" onclick="JTable.remove(this)">Eliminar</button></td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                                <button type="button" name="btndiscaddtrack" class="button-large" onclick="JTable.add($(this).parent().find('table'))">Agregar otro</button>
                            </td>
                            <td class="cell-4">
                                <?php if( !empty($rowDisc['thumb']) ){?>
                                <a href="<?=UPLOAD_DISC_DIR . $rowDisc['image']?>" class="jq-thumb"><img src="<?=UPLOAD_DISC_DIR . $rowDisc['thumb']?>" alt="<?=$rowDisc['thumb']?>" width="<?=$rowDisc['width']?>" height="<?=$rowDisc['height']?>" /></a><br />
                                <?php }?>
                                <input type="file" size="5" name="txtDiscImage<?=$rowDisc['discografica_id']!=0 ? 'Edit' : ''?>[]" />
                                <?php if( $rowDisc['discografica_id']!=0 ){?><input type="hidden" name="discografica_id[]" value="<?=$rowDisc['discografica_id']?>" /><?php }?>
                            </td>
                            <td class="cell-5"><button type="button" name="btndiscremove" class="button-medium" onclick="Bandas.removeDisc(this)">Eliminar</button></td>
                        </tr>
                <?php }?>
                    </tbody>
                </table>                
                <button type="button" class="button-large" name="btndiscadd" onclick="Bandas.addDisc()">Agregar otro</button>
            </div>

            <!-- ========== HISTORIA DE LA BANDA =========== -->
            <div class="clear float-left prepend-top">
                <label class="label-form" for="txtHistory">Historia de la Banda:</label><br />
                <textarea name="txtHistory" id="txtHistory" cols="22" rows="5" class="textarea-form"><?=$info['history']?></textarea>
            </div>

            <!-- ========== TOCANDO DESDE =========== -->
            <div class="clear float-left">
                <label class="label-form" for="txtTocandoDesde">Tocando Desde:</label><br />
                <input type="text" id="txtTocandoDesde" name="txtTocandoDesde" class="input-form" value="<?=$info['tocando_desde'];?>" />
            </div>

            <!-- ========== MANAGER =========== -->
            <div class="clear float-left">
                <label class="label-form" for="optManager">Manager</label>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;Si</span><input type="radio" name="optManager" onclick="Bandas.showhide_manager('show')" value="1" <?php if( $info['manager_visible']==1 ) echo 'checked="checked"';?> />&nbsp;&nbsp;
                <span>No</span><input type="radio" name="optManager" onclick="Bandas.showhide_manager('hide')" value="0" <?php if( !isset($info['manager_visible']) || $info['manager_visible']==0 ) echo 'checked="checked"';?> />
            </div>

            <div id="contManager" class="clear float-left prepend-top <?php if( $info['manager_visible']!=1 ) echo 'hide';?>">
                <div class="span-10">
                    <label class="label-form float-left" for="txtManagerName">Nombre</label>
                    <input type="text" id="txtManagerName" name="txtManagerName" class="input-form float-right" value="<?=$info['manager_name'];?>" />
                </div>
                <div class="clear span-10">
                    <label class="label-form float-left" for="txtManagerPhone">Telefono</label>
                    <input type="text" id="txtManagerPhone" name="txtManagerPhone" class="input-form float-right" value="<?=$info['manager_phone'];?>" />
                </div>
                <div class="clear span-10">
                    <label class="label-form float-left" for="txtManagerEmail">E-Mail</label>
                    <input type="text" id="txtManagerEmail" name="txtManagerEmail" class="input-form float-right" value="<?=$info['manager_mail'];?>" />
                </div>
            </div>

            <!-- ========== CONTACTO DE PRENSA =========== -->
            <div class="clear float-left">
                <label class="label-form">Contacto de Prensa:</label>
            </div>

            <div class="clear float-left">
                <div class="span-10">
                    <label class="label-form float-left" for="txtContactName">Nombre</label>
                    <input type="text" id="txtContactName" name="txtContactName" class="input-form float-right" value="<?=$info['contact_name'];?>" />
                </div>
                <div class="clear span-10">
                    <label class="label-form float-left" for="txtContactPhone">Telefono</label>
                    <input type="text" id="txtContactPhone" name="txtContactPhone" class="input-form float-right" value="<?=$info['contact_phone'];?>" />
                </div>
                <div class="clear span-10">
                    <label class="label-form float-left" for="txtContactEmail">E-Mail</label>
                    <input type="text" id="txtContactEmail" name="txtContactEmail" class="input-form float-right" value="<?=$info['contact_mail'];?>" />
                </div>
            </div>

            <!-- ========== OTROS CONTACTOS =========== -->
            <div class="clear float-left">
                <label class="label-form">Otros Contactos:</label>
            </div>

            <div class="clear float-left">
                <table id="tblOtherContact" class="table-othercontact" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td class="cell-1">Nombre</td>
                            <td class="cell-2">Telefono</td>
                            <td class="cell-3">E-Mail</td>
                            <td class="cell-4">Acci&oacute;n</td>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                $listOtherContact = array();
                $listOtherContact[] = array('name'=>'', 'phone'=>'', 'email'=>'');
                if( isset($info['listOtherContact']) ){
                    if( $info['listOtherContact']->num_rows>0 ) $listOtherContact = $info['listOtherContact']->result_array();
                }?>
                <?php foreach( $listOtherContact as $rowOC ) {?>
                        <tr>
                            <td class="cell-1"><input type="text" class="input-table" name="txtContactOtherName[]" value="<?=$rowOC['name']?>" /></td>
                            <td class="cell-2"><input type="text" class="input-table" name="txtContactOtherPhone[]" value="<?=$rowOC['phone']?>" /></td>
                            <td class="cell-3"><input type="text" class="input-table" name="txtContactOtherEmail[]" value="<?=$rowOC['email']?>" /></td>
                            <td class="cell-4"><button type="button" name="btnothercontactdel" class="button-medium" onclick="JTable.remove(this)">Eliminar</button></td>
                        </tr>
                <?php }?>
                    </tbody>
                </table>
                <button type="button" name="btnothercontactadd" class="button-large" onclick="JTable.add('#tblOtherContact')">Agregar otro</button>
            </div>

            <!-- ========== LA BANDA EN LA WEB =========== -->
            <div class="clear float-left">
                <label class="label-form">La banda en la Web:</label>
            </div>

            <div class="clear float-left">
                <table id="tblBandaWeb" class="table-bandaweb" cellpadding="0" cellspacing="0">
                    <tbody>
                <?php
                $listWebLink = array();
                $listWebLink[] = array('title'=>'', 'title_other'=>'', 'url'=>'');
                if( isset($info['listWebLink']) ){
                    if( $info['listWebLink']->num_rows>0 ) $listWebLink = $info['listWebLink']->result_array();
                }?>
                <?php foreach( $listWebLink as $rowWL ) {?>
                        <tr>
                            <td class="cell-1">
                                <select name="cboBandaWeb[]" onchange="Bandas.change_bandaweb(this)">
                                    <option value="">&nbsp;</option>
                                    <option value="Sitio Web" <?php if( $rowWL['title']=="Sitio Web" ) echo 'selected="selected"';?>>Sitio Web</option>
                                    <option value="Youtube" <?php if( $rowWL['title']=="Youtube" ) echo 'selected="selected"';?>>Youtube</option>
                                    <option value="Twitter" <?php if( $rowWL['title']=="Twitter" ) echo 'selected="selected"';?>>Twitter</option>
                                    <option value="Fotolog" <?php if( $rowWL['title']=="Fotolog" ) echo 'selected="selected"';?>>Fotolog</option>
                                    <option value="MySpace" <?php if( $rowWL['title']=="MySpace" ) echo 'selected="selected"';?>>MySpace</option>
                                    <option value="El Sonar" <?php if( $rowWL['title']=="El Sonar" ) echo 'selected="selected"';?>>El Sonar</option>
                                    <option value="Puro Volumen" <?php if( $rowWL['title']=="Puro Volumen" ) echo 'selected="selected"';?>>Puro Volumen</option>
                                    <option value="other" <?php if( $rowWL['title']=="other" ) echo 'selected="selected"';?>>Otro</option>
                                </select>
                                <input type="text" class="input-table <?php if( $rowWL['title']!="other" ) echo 'hide'?>" name="txtOtherBanda[]" value="<?=$rowWL['title_other']?>" />
                            </td>
                            <td class="cell-2"><input type="text" class="input-table" name="txtBandaWebVal[]" value="<?=$rowWL['url']?>" /></td>
                            <td class="cell-3"><button type="button" name="btnbandadel" class="button-medium" onclick="JTable.remove(this)">Eliminar</button></td>
                        </tr>
                <?php }?>
                    </tbody>
                </table>
                <button type="button" name="btnbandaadd" class="button-large" onclick="JTable.add('#tblBandaWeb')">Agregar otro</button>
            </div>

            <!-- ========== LINKS DE INTERES =========== -->
            <div class="clear prepend-top float-left">
                <label class="label-form">Links de Interes:</label><br />
                <table id="tblLinksInteres" class="table-integrantes" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td class="cell-1">T&iacute;tulo</td>
                            <td class="cell-2">URL</td>
                            <td class="cell-3">Acci&oacute;n</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $listLinksInteres = array();
                    $listLinksInteres[] = array('title'=>'', 'url'=>'');
                    if( isset($info['listLinksInteres']) ){
                        if( $info['listLinksInteres']->num_rows>0 )
                            $listLinksInteres = $info['listLinksInteres']->result_array();
                    }
                    ?>
                    <?php foreach( $listLinksInteres as $row ){?>
                        <tr>
                            <td class="cell-1"><input type="text" class="input-table" name="txtLinksInteresTitle[]" value="<?=$row['title']?>" /></td>
                            <td class="cell-2"><input type="text" class="input-table" name="txtLinksInteresUrl[]" value="<?=$row['url']?>" /></td>
                            <td class="cell-3"><button type="button" name="btnlinksinteresdel" class="button-medium" onclick="JTable.remove(this)">Eliminar</button></td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <button type="button" name="btnlinksinteresadd" class="button-large" onclick="JTable.add('#tblLinksInteres')">Agregar otro</button>
            </div>

            <!-- ========== MAS INFO =========== -->
            <div class="clear float-left prepend-top">
                <label class="label-form" for="txtMoreInfo">Mas Info:</label><br />
                <textarea name="txtMoreInfo" id="txtMoreInfo" cols="22" rows="5" class="textarea-form"><?=$info['masinfo']?></textarea>
            </div>

            <div class="clear text-center"><br />
                <button type="submit" class="button-large">Guardar</button>
            </div>

            <input type="hidden" name="bandas_id" value="<?=$info['bandas_id'];?>" />
            <input type="hidden" name="extra_post" id="extra_post" value="" />
        </form>

        <script type="text/javascript">
        <!--
            Bandas.initializer({mode : '<?=!$info ? 'create' : 'edit';?>'});
        -->
        </script>
        