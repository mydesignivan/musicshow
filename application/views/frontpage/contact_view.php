    <h1>Contacto</h1>

    <?php if( $this->session->flashdata('statusmail')=="ok" ){?>
            <p>Muchas gracias por comunicarse,</p>
            <p>En breve estaremos en contacto.</p>

    <?php }else{?>
        <form id="form1" action="<?=site_url('/contacto/send');?>" enctype="application/x-www-form-urlencoded" method="post">
            <p>
                <span class="required">*</span><label class="label-form" for="txtName">Nombre Completo:</label><br />
                <input type="text" name="txtName" id="txtName" class="input-form validate" />
            </p>
            <p>
                <span class="required">*</span><label class="label-form" for="txtEmail">Direcci&oacute;n de E-Mail:</label><br />
                <input type="text" name="txtEmail" id="txtEmail" class="input-form validate" />
            </p>
            <p>
                <label class="label-form" for="txtPhone">Telefono:</label><br />
                <input type="text" name="txtPhone" id="txtPhone" class="input-form" />
            </p>
            <p>
                <label class="label-form" for="txtState">Provincia:</label><br />
                <input type="text" name="txtState" id="txtState" class="input-form" />
            </p>
            <p>
                <label class="label-form" for="txtCity">Ciudad:</label><br />
                <input type="text" name="txtCity" id="txtCity" class="input-form" />
            </p>
            <p>
                <label class="label-form" for="txtEmail">Area de Contacto:</label><br />
                <select name="cboArea" id="cboArea" class="select-form">
                    <option value="info@musicshows.com.ar">Administraci&oacute;n</option>
                    <option value="publicidad@musicshows.com.ar">Publicidad</option>
                </select>
            </p>
            <p>
                <span class="required">*</span><label for="txtConsult">Consulta:</label><br />
                <textarea name="txtConsult" id="txtConsult" rows="10" cols="22" class="textarea-contact validate"></textarea>
            </p>

            <br />
            <label class="label-legend">(*) Campos Obligatorios</label>

            <p class="prepend-top span-12 text-center">
                <button type="button" onclick="Contact.send();" class="button-medium">Enviar</button>
            </p>
        </form>


        <script type="text/javascript">
        <!--
            Contact.initializer();
        -->
        </script>

    <?php }?>