        <h1><?=$title;?></h1>

        <form id="form1" action="<?=site_url(!$info ? '/paneluser/bandas/create/' : '/paneluser/bandas/edit/');?>" method="post" class="container-form" enctype="multipart/form-data">
            <?php require('application/views/includes/popup_inc.php');?>

            <!-- ========== NOMBRE BANDA =========== -->
            <p>
                <span class="required">*</span><label class="label-form" for="txtBanda">Nombre banda</label><br />
                <input type="text" id="txtBanda" name="txtBanda" class="input-form" value="<?=$info['banda'];?>" />
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
                <select name="cboCity" id="cboCity" class="select-form">
                    <option value="">Seleccione una Provincia</option>
                </select>
            </p>
            <!-- ========== INFLUENCIAS =========== -->
            <p>
                <span class="required">*</span><label class="label-form" for="txtInfluencias">Influencias</label><br />
                <textarea name="txtInfluencias" id="txtInfluencias" cols="22" rows="5" class="textarea-form"></textarea>
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
                        <tr>
                            <td class="cell-1"><input type="text" class="input-table" name="txtIntegName[]" /></td>
                            <td class="cell-2"><input type="text" class="input-table" name="txtIntegInstr[]" /></td>
                            <td class="cell-3"><button type="button" name="btnintdel" class="button-medium" onclick="JTable.remove(this)">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" name="btnintadd" class="button-large" onclick="JTable.add('#tblIntegrantes')">Agregar otro</button>
                <div id="msgbox-integrantes" class="hide clear prepend-top error"></div>
            </div>

            <!-- ========== IMAGENES =========== -->
            <div class="clear float-left prepend-top">
                <span class="required">*</span><label class="label-form">Im&aacute;genes</label><br />

                <ul id="contImages">
                    <li>
                        <div class="span-3">
                            <span>Im&aacute;gen</span><br />
                            <span>Comentario</span>
                        </div>
                        <div class="span-13 last">
                            <input type="file" name="txtImage[]" size="15" />
                            <button type="button" name="btnimg" class="button-medium" onclick="Bandas.attach_file_remove(this)">Eliminar</button><br />

                            <textarea name="txtImageComment" cols="22" rows="5" class="textarea-small"></textarea>
                        </div>
                    </li>
                </ul>
                <a href="javascript:void(Bandas.attach_file())" class="link1">Adjuntar otra im&aacute;gen</a>
                <div id="msgbox-image" class="hide clear prepend-top error"></div>
            </div>

            <!-- ========== DISCOGRAFICA =========== -->
            <div class="float-left clear prepend-top">
                <label class="label-form" for="optDiscografia">Discogr&aacute;fica</label>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;Si</span><input type="radio" name="optDiscografia" onclick="$('#contDiscografica').fadeIn('slow')" value="1" />&nbsp;&nbsp;
                <span>No</span><input type="radio" name="optDiscografia" checked  onclick="$('#contDiscografica').fadeOut('slow')" value="0" />
            </div>

            <div id="contDiscografica" class="clear float-left prepend-top hide">
                <label class="label-form" for="txtDiscActual">Discogr&aacute;fica Actual</label>&nbsp;<input type="text" id="txtDiscActual" name="txtDiscActual" class="input-form" value="" />

                <table id="tblDiscografica" class="table-discografica" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td class="cell-1">Nombre del CD</td>
                            <td class="cell-2">Discogr&aacute;fica</td>
                            <td class="cell-3">Temas</td>
                            <td class="cell-4">Tapa del CD</td>
                            <td class="cell-5">Acci&oacute;n</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="cell-1"><input type="text" class="input-table" name="txtDiscCDname[]" /></td>
                            <td class="cell-2"><input type="text" class="input-table" name="txtDiscName[]" /></td>
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
                                        <tr>
                                            <td class="cell1"><input type="text" name="txtTrackName" class="input-table" /></td>
                                            <td class="cell2"><input type="text" name="txtTrackMin" class="input-table jq-field-int" /></td>
                                            <td class="cell3"><button type="button" name="btndiscdeltrack" class="button-medium" onclick="JTable.remove(this)">Eliminar</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" name="btndiscaddtrack" class="button-large" onclick="JTable.add($(this).parent().find('table'))">Agregar otro</button>
                            </td>
                            <td class="cell-4">
                                <input type="file" size="5" name="txtDiscImage[]" />
                            </td>
                            <td class="cell-5"><button type="button" name="btndiscremove" class="button-medium" onclick="JTable.remove(this)">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>                
                <button type="button" class="button-large" name="btndiscadd" onclick="JTable.add('#tblDiscografica')">Agregar otro</button>
            </div>

            <!-- ========== HISTORIA DE LA BANDA =========== -->
            <div class="clear float-left prepend-top">
                <label class="label-form" for="txtHistory">Historia de la Banda:</label><br />
                <textarea name="txtHistory" cols="22" rows="5" class="textarea-form"></textarea>
            </div>

            <!-- ========== TOCANDO DESDE =========== -->
            <div class="clear float-left">
                <label class="label-form" for="txtTocandoDesde">Tocando Desde:</label><br />
                <input type="text" id="txtTocandoDesde" name="txtTocandoDesde" class="input-form" value="<?=$info['tocando_desde'];?>" />
            </div>

            <!-- ========== MANAGER =========== -->
            <div class="clear float-left">
                <label class="label-form" for="optManager">Manager</label>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;Si</span><input type="radio" name="optManager" onclick="$('#contManager').fadeIn('slow')" value="1" />&nbsp;&nbsp;
                <span>No</span><input type="radio" name="optManager" checked onclick="$('#contManager').fadeOut('slow')" value="0" />
            </div>

            <div id="contManager" class="clear float-left prepend-top hide">
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
                    <input type="text" id="txtManagerEmail" name="txtManagerEmail" class="input-form float-right" value="<?=$info['manager_email'];?>" />
                </div>
            </div>

            <!-- ========== CONTACTO DE PRENSA =========== -->
            <div class="clear float-left">
                <label class="label-form" for="txtContactPrensa">Contacto de Prensa:</label>
            </div>

            <div class="clear float-left">
                <div class="span-10">
                    <label class="label-form float-left" for="txtContactName">Nombre</label>
                    <input type="text" id="txtManagerName" name="txtContactName" class="input-form float-right" value="<?=$info['manager_name'];?>" />
                </div>
                <div class="clear span-10">
                    <label class="label-form float-left" for="txtContactPhone">Telefono</label>
                    <input type="text" id="txtContactPhone" name="txtContactPhone" class="input-form float-right" value="<?=$info['manager_phone'];?>" />
                </div>
                <div class="clear span-10">
                    <label class="label-form float-left" for="txtContactEmail">E-Mail</label>
                    <input type="text" id="txtContactEmail" name="txtContactEmail" class="input-form float-right" value="<?=$info['manager_email'];?>" />
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
                        <tr>
                            <td class="cell-1"><input type="text" class="input-table" name="txtContactOtherName[]" /></td>
                            <td class="cell-2"><input type="text" class="input-table" name="txtContactOtherPhone[]" /></td>
                            <td class="cell-3"><input type="text" class="input-table" name="txtContactOtherEmail[]" /></td>
                            <td class="cell-4"><button type="button" name="btnothercontactdel" class="button-medium" onclick="JTable.remove(this)">Eliminar</button></td>
                        </tr>
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
                        <tr>
                            <td class="cell-1">
                                <select name="cboBandaWeb[]" onchange="Bandas.change_bandaweb(this)">
                                    <option value="">&nbsp;</option>
                                    <option value="Sitio Web">Sitio Web</option>
                                    <option value="Youtube">Youtube</option>
                                    <option value="Twitter">Twitter</option>
                                    <option value="Fotolog">Fotolog</option>
                                    <option value="MySpace">MySpace</option>
                                    <option value="El Sonar">El Sonar</option>
                                    <option value="Puro Volumen">Puro Volumen</option>
                                    <option value="other">Otro</option>
                                </select>
                                <input type="text" class="input-table hide" name="txtOtherBanda[]" />
                            </td>
                            <td class="cell-2"><input type="text" class="input-table" name="txtBandaWebVal[]" /></td>
                            <td class="cell-3"><button type="button" name="btnbandadel" class="button-medium" onclick="JTable.remove(this)">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" name="btnbandaadd" class="button-large" onclick="JTable.add('#tblBandaWeb')">Agregar otro</button>
            </div>

            <!-- ========== LINKS DE INTERES =========== -->
            <div class="clear float-left">
                <label class="label-form" for="txtContactPrensa">Links de Interes:</label>
            </div>
            <div class="clear float-left">
                <label class="label-form" for="txtLinksInteresTitle">T&iacute;tulo:</label>
                <input type="text" id="txtLinksInteresTitle" name="txtLinksInteresTitle" class="input-form" value="<?=$info['manager_phone'];?>" /><br />

                <label class="label-form" for="txtLinksInteresUrl">URL:</label>
                <input type="text" id="txtLinksInteresUrl" name="txtLinksInteresUrl" class="input-form" value="<?=$info['manager_phone'];?>" />
            </div>

            <!-- ========== MAS INFO =========== -->
            <div class="clear float-left prepend-top">
                <label class="label-form" for="txtMoreInfo">Mas Info:</label><br />
                <textarea name="txtMoreInfo" id="txtMoreInfo" cols="22" rows="5" class="textarea-form"></textarea>
            </div>

            <div class="clear text-center"><br />
                <button type="submit" class="button-large">Guardar</button>
            </div>

            <input type="hidden" name="banda_id" value="<?=$info['banda_id'];?>" />
            <input type="hidden" name="extra_post" id="extra_post" value="" />
        </form>

        <script type="text/javascript">
        <!--
            Bandas.initializer({mode : '<?=!$info ? 'create' : 'edit';?>'});
        -->
        </script>
        