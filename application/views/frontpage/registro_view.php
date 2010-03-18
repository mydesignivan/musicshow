        <h1>Formulario de Registro</h1>

<?php if( !$this->session->flashdata('statusrecord') ){?>
        <form id="form1" action="<?=site_url('/registro/create/');?>" style="position: relative;" method="post" class="container-form" enctype="application/x-www-form-urlencoded">
            <div id="mask"></div>
            <?php require('application/views/includes/popup_inc.php');?>

            <!-- =================  DATOS DEL USUARIO  ================ -->
            <h2 class="title-form">Datos del Usuario</h2>
            <p>
                <span class="required">*</span><label class="label-form" for="txtUser">Usuario</label><br />
                <input type="text" id="txtUser" name="txtUser" class="input-form validate" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtPass">Contrase&ntilde;a</label><br />
                <input type="password" id="txtPass" name="txtPass" class="input-form validate" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtPass_confirm">Repite Contrase&ntilde;a</label><br />
                <input type="password" id="txtPass_confirm" name="txtPass_confirm" class="input-form validate" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtEmail">E-Mail</label><br />
                <input type="text" id="txtEmail" name="txtEmail" class="input-form validate" onchange="this.value = this.value.toLowerCase();" />
            </p>
            <p>
                <input type="checkbox" name="chkNewsletter" value="1" /><span class="text-medium">&nbsp;Deseo recibir Novedades de Music Shows</span>
            </p>

            <!-- =================  DATOS DEL PERSONALES  ================ -->
            <h2 class="title-form">Datos Personales</h2>
            <p>
                <span class="required">*</span><label class="label-form" for="txtLastName">Apellido</label><br />
                <input type="text" id="txtLastName" name="txtLastName" class="input-form validate" onchange="$(this).ucTitle();" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtFirstName">Nombre</label><br />
                <input type="text" id="txtFirstName" name="txtFirstName" class="input-form validate" onchange="$(this).ucTitle();" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="cboCountry">Pa&iacute;s</label><br />
                <?=form_dropdown('cboCountry', $comboCountry, '0', 'onchange="Account.show_states(this);" class="select-form validate" id="cboCountry"');?>
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="cboStates">Provincia</label><br />
                <select name="cboStates" id="cboStates" class="select-form validate">
                    <option value="0">Seleccione un Pa&iacute;s</option>
                </select>
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtCity">Ciudad</label><br />
                <input type="text" id="txtCity" name="txtCity" class="input-form validate" onchange="$(this).ucFirst();" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtPhone">Telefono</label><br />
                <input type="text" id="txtPhoneArea" name="txtPhoneArea" class="input-phonearea validate" />&nbsp;-&nbsp;
                <input type="text" id="txtPhone" name="txtPhone" class="input-phone validate" />
            </p>
            <p>
                <label class="label-form" for="txtAddress">Domicilio</label><br />
                <input type="text" id="txtAddress" name="txtAddress" class="input-form" />
            </p>
            <div class="span-10 append-bottom">
                <img id="imgCaptcha" src="<?=site_url('/captcha/index/'.md5(time()));?>" align="left" border="1" alt="" class="float-left" />
                <div class="float-left">
                    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="19" height="19" id="SecurImage_as3" align="middle">
                        <param name="allowScriptAccess" value="sameDomain" />
                        <param name="allowFullScreen" value="false" />
                        <param name="movie" value="images/securimage_play.swf?audio=<?=site_url('/captcha/play/');?>&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
                        <param name="quality" value="high" />
                        <param name="bgcolor" value="#ffffff" />
                        <embed src="images/securimage_play.swf?audio=<?=site_url('/captcha/play/');?>&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" quality="high" bgcolor="#ffffff" width="19" height="19" name="SecurImage_as3" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
                    </object>
                    <br />
                    <a href="javascript:void($('#imgCaptcha').attr('src', ('<?=site_url('/captcha/index/');?>/'+Math.random()).replace('index.html', 'index')));" tabindex="-1" title="Mostrar otro"><img src="images/icon_refresh.gif" alt="Mostrar otro" onclick="this.blur()" align="bottom" /></a>
                </div>
            </div>
            <div class="clear span-13">
                    <span class="required float-left">*</span>
                    <label class="label-form float-left" for="txtCode">Ingrese el c&oacute;digo de arriba:</label>
                    <input type="text" id="txtCode" name="txtCode" maxlength="6" class="input-captcha float-left validate" />
            </div>

            <!-- =================  FIN DATOS PERSONALES ================== -->

            <p class="clear"><br /><label class="label-legend">(*) Campos Obligatorios</label></p>

            <p class="clear span-15 text-center">
                <button type="button" class="button-large" onclick="Account.save();">Registrarme</button>
            </p>
        </form>

        <script type="text/javascript">
        <!--
            Account.initializer();
        -->
        </script>

    <?php }elseif( $this->session->flashdata('statusrecord')=="saveok" ){?>

            <p>Gracias por registrarte, <?=$this->session->flashdata('name');?>. Un correo ha sido enviado a <?=$this->session->flashdata('email');?> con detalles de como activar tu cuenta.</p>

            <p>Recibiras un correo en tu bandeja de entrada. Debes seguir el enlace en ese correo antes de logearte.</p>

    <?php }?>
