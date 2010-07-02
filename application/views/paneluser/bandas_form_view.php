        <h1><?=$title;?></h1>

        <form id="form1" action="<?=site_url(!$info ? '/paneluser/bandas/create/' : '/paneluser/bandas/edit/');?>" method="post" class="container-form" enctype="multipart/form-data">
            <?php require('application/views/includes/popup_inc.php');?>

            <!-- ========== NOMBRE BANDA =========== -->
            <p>
                <span class="required">*</span><label class="label-form" for="txtBanda">Nombre banda</label><br />
                <input type="text" id="txtBanda" name="txtBanda" class="input-form validate" value="<?=$info['banda'];?>" />
            </p>
            <!-- ========== GENERO =========== -->
            <p>
                <span class="required">*</span><label class="label-form" for="txtGenero">Genero</label><br />
                <input type="text" id="txtGenero" name="txtGenero" class="input-form validate" value="<?=$info['genero'];?>" />
            </p>
            <!-- ========== PROVINCIA =========== -->
            <p>
                <span class="required">*</span><label class="label-form" for="cboStates">Provincia</label><br />
                <?=form_dropdown('cboStates', $comboStates,  @$info['state_id'], 'class="select-form validate" id="cboStates"');?>
            </p>
            <!-- ========== CIUDAD =========== -->
            <p>
                <span class="required">*</span><label class="label-form" for="cboCity">Ciudad</label><br />
                <select name="cboCity" id="cboCity" class="select-form validate">
                    <option value="0">Seleccione una Ciudad</option>
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
                            <td class="cell-1"><input type="text" class="input-table" /></td>
                            <td class="cell-2"><input type="text" class="input-table" /></td>
                            <td class="cell-3"><button type="button" class="button-medium">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="button-large">Agregar otro</button>
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
                        <div class="span-6 last">
                            <input type="file" name="txtImage" size="20" /><br />
                            <textarea name="txtImageComment" cols="22" rows="5" class="textarea-small"></textarea>
                        </div>
                    </li>
                </ul>
                <a href="" class="link1">Adjuntar otra im&aacute;gen</a>
            </div>

            <!-- ========== DISCOGRAFICA =========== -->
            <div class="float-left clear prepend-top">
                <label class="label-form" for="txtGenero">Discogr&aacute;fica</label>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;Si</span><input type="radio" name="optDiscografia" />&nbsp;&nbsp;
                <span>No</span><input type="radio" name="optDiscografia" checked />
            </div>

            <div id="contDiscografica" class="clear float-left prepend-top">
                <label class="label-form" for="txtGenero">Discogr&aacute;fica Actual</label>&nbsp;<input type="text" id="txtDiscActual" name="txtDiscActual" class="input-form validate" value="" />

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
                            <td class="cell-1"><input type="text" class="input-table" /></td>
                            <td class="cell-2"><input type="text" class="input-table" /></td>
                            <td class="cell-3">
                                <table id="tblDiscografica" class="table-temas-discografica" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td class="cell-1">Nombre</td>
                                            <td class="cell-2">Minutos</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="cell-1"><input type="text" class="input-table" /></td>
                                            <td class="cell-2"><input type="text" class="input-table" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="button-large">Agregar otro</button>
                            </td>
                            <td class="cell-4">
                                
                            </td>
                            <td class="cell-5"><button type="button" class="button-medium">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>                
                <button type="button" class="button-large">Agregar otro</button>
            </div>

            <!-- ========== HISTORIA DE LA BANDA =========== -->
            <div class="clear float-left prepend-top">
                <label class="label-form" for="txtHistory">Historia de la Banda:</label><br />
                <textarea name="txtHistory" cols="22" rows="5" class="textarea-form"></textarea>
            </div>

            <!-- ========== TOCANDO DESDE =========== -->
            <div class="clear float-left">
                <label class="label-form" for="txtGenero">Tocando Desde:</label><br />
                <input type="text" id="txtTocandoDesde" name="txtTocandoDesde" class="input-form validate" value="<?=$info['tocando_desde'];?>" />
            </div>

            <!-- ========== MANAGER =========== -->
            <div class="clear float-left">
                <label class="label-form" for="txtGenero">Manager</label>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;Si</span><input type="radio" name="optManager" />&nbsp;&nbsp;
                <span>No</span><input type="radio" name="optManager" checked />
            </div>

            <div id="contManager" class="clear float-left prepend-top">
                <div class="span-10">
                    <label class="label-form float-left" for="txtGenero">Nombre</label>
                    <input type="text" id="txtManagerName" name="txtManagerName" class="input-form validate float-right" value="<?=$info['manager_name'];?>" />
                </div>
                <div class="clear span-10">
                    <label class="label-form float-left" for="txtGenero">Telefono</label>
                    <input type="text" id="txtManagerPhone" name="txtManagerPhone" class="input-form validate float-right" value="<?=$info['manager_phone'];?>" />
                </div>
                <div class="clear span-10">
                    <label class="label-form float-left" for="txtGenero">E-Mail</label>
                    <input type="text" id="txtManagerEmail" name="txtManagerEmail" class="input-form validate float-right" value="<?=$info['manager_email'];?>" />
                </div>
            </div>

            <!-- ========== CONTACTO DE PRENSA =========== -->
            <div class="clear float-left">
                <label class="label-form" for="txtContactPrensa">Contacto de Prensa:</label>
            </div>

            <div class="clear float-left">
                <div class="span-10">
                    <label class="label-form float-left" for="txtContactName">Nombre</label>
                    <input type="text" id="txtManagerName" name="txtContactName" class="input-form validate float-right" value="<?=$info['manager_name'];?>" />
                </div>
                <div class="clear span-10">
                    <label class="label-form float-left" for="txtContactPhone">Telefono</label>
                    <input type="text" id="txtContactPhone" name="txtContactPhone" class="input-form validate float-right" value="<?=$info['manager_phone'];?>" />
                </div>
                <div class="clear span-10">
                    <label class="label-form float-left" for="txtContactEmail">E-Mail</label>
                    <input type="text" id="txtContactEmail" name="txtContactEmail" class="input-form validate float-right" value="<?=$info['manager_email'];?>" />
                </div>
            </div>

            <!-- ========== LA BANDA EN LA WEB =========== -->
            <div class="clear float-left">
                <label class="label-form" for="txtContactPrensa">La banda en la Web:</label>&nbsp;&nbsp;
                <select id="cboBandaWeb" name="cboBandaWeb">
                    <option value="Sitio Web">Sitio Web</option>
                    <option value="Youtube">Youtube</option>
                    <option value="Twitter">Twitter</option>
                    <option value="Fotolog">Fotolog</option>
                    <option value="MySpace">MySpace</option>
                    <option value="El Sonar">El Sonar</option>
                    <option value="Puro Volumen">Puro Volumen</option>
                    <option value="other">Otro</option>
                </select>
                <input type="text" name="txtBandaWebUrl" id="txtBandaWebUrl" class="input-form" />
            </div>

            <!-- ========== LINKS DE INTERES =========== -->
            <div class="clear float-left">
                <label class="label-form" for="txtContactPrensa">Links de Interes:</label>
            </div>
            <div class="clear float-left">
                <label class="label-form" for="txtUrl">URL:</label>
                <input type="text" id="txtUrl" name="txtUrl" class="input-form validate" value="<?=$info['manager_phone'];?>" /><br />

                <label class="label-form" for="txtUrl">T&iacute;tulo:</label>
                <input type="text" id="txtUrl" name="txtUrl" class="input-form validate" value="<?=$info['manager_phone'];?>" />
            </div>

            <!-- ========== MAS INFO =========== -->
            <div class="clear float-left prepend-top">
                <label class="label-form" for="txtHistory">Mas Info:</label><br />
                <textarea name="txtHistory" cols="22" rows="5" class="textarea-form"></textarea>
            </div>

            <input type="hidden" name="banda_id" value="<?=$info['banda_id'];?>" />

            <div class="clear text-center"><br />
                <button type="button" class="button-large">Guardar</button>
            </div>
        </form>



        <script type="text/javascript">
        <!--
            Bandas.initializer(<?=!$info ? 'false' : 'true';?>);
        -->
        </script>
        