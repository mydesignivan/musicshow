<div id="header">
    <div id="top">
        <div class="topmenu-top"></div>

        <div align="left"></div>
        <div id="bannertop">
            <div align="left"><a href="<?=site_url('/registro/');?>"><img src="../images/bannertop.png" alt="Registrate Gratis!" /></a></div>
        </div>
        <div align="left"></div>

        <div class="login">
            <form id="formLogin" action="" method="post" enctype="application/x-www-form-urlencoded">
                <div class="login-opcional"><a href="#" onclick="Login.remember_pass.show_dialog(this);return false;">Olvidaste tu Contrase&ntilde;a?</a></div>

                <input class="input" type="text" name="txtUser" value="Usuario" onfocus="clear_input(event)" onblur="set_input(event, 'Usuario')" />
                <input class="input" type="text" name="txtPass" value="Contrase&ntilde;a" onfocus="clear_input(event, 1)" onblur="set_input(event, 'Contrase&ntilde;a', 1)" />
                <input type="submit" value="Entrar" id="login" />
            </form>
        </div>
    </div>


    <div id="topmenu">
        <ul>
            <li><a href="<?=site_url('/')?>"><img src="images/botonoinicio.png" alt="" /></a></li>
            <li><a href="<?=site_url('/fechas/');?>"><img src="images/botonfechas.png" alt="" /></a></li>
            <li><a href="<?=site_url('/bandas/');?>"><img src="images/botonbandas.png" alt="" /></a></li>
            <li><a href="<?=site_url('/contacto/');?>"><img src="images/botoncontacto.png" alt="" /></a></li>
        </ul>
    </div>

    <div id="search"></div>

    <div id="banner-centro">
      <p>
            <script type="text/javascript">
            <!--
                AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','542','height','55','src','images/flash/banner','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','images/flash/banner' ); //end AC code
            -->
            </script>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="542" height="55">
                <param name="movie" value="images/flash/banner.swf" />
                <param name="quality" value="high" />
                <embed src="images/flash/banner.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="542" height="55"></embed>
            </object>
      </p>
    </div>
</div>