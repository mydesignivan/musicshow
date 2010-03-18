        <h1>Mi Cuenta</h1>

        <form id="form1" action="<?=site_url('/panel/micuenta/modified/');?>" method="post" class="container-form" enctype="application/x-www-form-urlencoded">
            <div id="mask"></div>
            <!--<div class="msgbox">
                <div class="top"></div>
                <div class="middle">
                    <p>Validando Formulario</p>
                    <img src="images/ajax-loader.gif" alt="Cargando..." />
                </div>
                <div class="bottom"></div>
            </div>-->

            <!-- =================  DATOS DEL USUARIO  ================ -->
            <h2 class="title-form">Datos del Usuario</h2>
            <p>
                <span class="required">*</span><label class="label-form" for="txtUser">Usuario</label><br />
                <input type="text" id="txtUser" name="txtUser" class="input-form validate" value="<?=$info['username'];?>" />
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
                <input type="text" id="txtEmail" name="txtEmail" class="input-form validate" onchange="this.value = this.value.toLowerCase();" value="<?=$info['email'];?>" />
            </p>
            <p>
                <input type="checkbox" name="chkNewsletter" value="1" <?=$info['newsletter']==1 ? 'checked="checked"' : '';?> /><span class="text-medium">&nbsp;Deseo recibir Novedades de Music Shows</span>
            </p>

            <!-- =================  DATOS DEL PERSONALES  ================ -->
            <h2 class="title-form">Datos Personales</h2>
            <p>
                <span class="required">*</span><label class="label-form" for="txtLastName">Apellido</label><br />
                <input type="text" id="txtLastName" name="txtLastName" class="input-form validate" onchange="$(this).ucTitle();" value="<?=$info['lastname'];?>" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtFirstName">Nombre</label><br />
                <input type="text" id="txtFirstName" name="txtFirstName" class="input-form validate" onchange="$(this).ucTitle();" value="<?=$info['firstname'];?>" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="cboCountry">Pa&iacute;s</label><br />
                <?=form_dropdown('cboCountry', $comboCountry, $info['country_id'], 'onchange="Account.show_states(this);" class="select-form validate" id="cboCountry"');?>
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="cboStates">Provincia</label><br />
                <?=form_dropdown('cboStates', $listStates,  $info['state_id'], 'class="validate" id="cboStates"');?>
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtCity">Ciudad</label><br />
                <input type="text" id="txtCity" name="txtCity" class="input-form validate" onchange="$(this).ucFirst();" value="<?=$info['city'];?>" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtPhone">Telefono</label><br />
                <input type="text" id="txtPhoneArea" name="txtPhoneArea" class="input-phonearea validate" value="<?=$info['phone_area'];?>" />&nbsp;-&nbsp;
                <input type="text" id="txtPhone" name="txtPhone" class="input-phone validate" value="<?=$info['phone'];?>" />
            </p>
            <p>
                <label class="label-form" for="txtAddress">Domicilio</label><br />
                <input type="text" id="txtAddress" name="txtAddress" class="input-form" value="<?=$info['address'];?>" />
            </p>
            <!-- =================  FIN DATOS PERSONALES ================== -->

            <p class="clear"><br /><label class="label-legend">(*) Campos Obligatorios</label></p>

            <p class="clear span-15 text-center">
                <button type="button" class="button-medium" onclick="Account.save();">Modificar</button>
            </p>

            <input type="hidden" name="user_id" value="<?=$info['user_id'];?>" />
        </form>

        <script type="text/javascript">
        <!--
            Account.initializer();
        -->
        </script>
