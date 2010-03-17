        <h1>Recordar Contrase&ntilde;a</h1>

        <form id="form1" action="<?=site_url('/recordarcontrasenia/send/');?>" method="post">
        <?php if( @$status=="ok" ){?>
            <p>Muy bien, le hemos enviado las instrucciones a su email. Reviselo!</p>
            <p>Usted puede mantener esta pagina abierta mientras chequea su email. Si usted no recibe las instrucciones en el transcurso de un minuto o dos pruebe <a href="javascript:$('#form1').submit();">Reenviar las instrucciones</a></p>
            <input type="hidden" name="txtField" id="txtField" value="<?=$field;?>" />

        <?php }else{?>

            <p>MusicShows.com.ar le enviara las instrucciones para resetear su contrase&ntilde;a a la direcci&oacute;n de correo asociada a su cuenta.</p>
            <br />
            <p>Por favor escriba su direcci&oacute;n de <b>email</b> o su <b>usuario</b> a continuaci&oacute;n.</p>

            <p><input type="text" name="txtField" id="txtField" class="input-form validate" /></p>

            <div class="span-10 append-bottom prepend-top">
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
            <div class="clear span-13 append-bottom">
                <span class="required float-left">*</span>
                <label class="label-form float-left" for="txtCode">Ingrese el c&oacute;digo de arriba:</label>
                <input type="text" id="txtCode" name="txtCode" maxlength="6" class="input-captcha float-left validate" />
            </div>

            <p class="clear span-15 text-center">
                <button type="button" class="button-medium" onclick="RememberPass.send();">Enviar</button>
            </p>
        <?php }?>
        </form>

        <script type="text/javascript">
        <!--
            RememberPass.initializer();
        -->
        </script>
