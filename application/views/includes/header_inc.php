<div id="header">
    <div id="top">
        <div class="topmenu-top"></div>

        <div align="left"></div>
        <div id="bannertop">
            <div align="left"><a href="<?=site_url('/registro/');?>"><img src="../images/bannertop.png" alt="Registrate Gratis!" /></a></div>
        </div>
        <div align="left"></div>

        <div class="login">
        <?php if( !$this->session->userdata('logged_in') ){?>
            <form id="formLogin" action="<?=site_url('/login/')?>" method="post" enctype="application/x-www-form-urlencoded">
                <div class="login-opcional"><a href="<?=site_url('/recordarcontrasenia/');?>">Olvidaste tu Contrase&ntilde;a?</a></div>

                <input class="input" type="text" name="txtLoginUser" class="inputbox2" value="Usuario" onfocus="clear_input(event)" onblur="set_input(event, 'Usuario')" />
                <input class="input" type="text" name="txtLoginPass" class="inputbox2" value="Contrase&ntilde;a" onfocus="clear_input(event, 1)" onblur="set_input(event, 'Contrase&ntilde;a', 1)" />
                <input type="submit" id="btnLogin" value="Entrar" class="inputlogin" />
            </form>
            <div id="validator-message-login"></div>

            <script type="text/javascript">
            <!--
             <?php
                if( $this->session->flashdata('statusLogin') ) {
                    switch($this->session->flashdata('statusLogin')){
                        case "loginfaild":
                            $message = "El usuario y/o password son incorrectos.";
                        break;
                        case "userinactive":
                            $message = "El usuario no esta activado.";
                        break;
                    }
                    echo '$("#validator-message-login").html("'.$message.'").show();';
                }
             ?>
                 
            -->
            </script>
            

        <?php }else{

            echo '<form id="formLogin" action="'.site_url('/login/logout').'" method="post" enctype="application/x-www-form-urlencoded">';
            echo 'Usuario: '.$this->session->userdata('email').' <a href="'.site_url('/micuenta/').'">(mi cuenta)</a> ';
            echo '<input type="submit" value="Salir" class="inputlogin" />';
            echo '</form>';
        
         }?>
        </div>


    </div>


    <div id="topmenu">
        <ul>
            <li><a href="<?=site_url('/index/')?>"><img src="images/botonoinicio.png" alt="" /></a></li>
            <li><a href="<?=site_url('/fechas/');?>"><img src="images/botonfechas.png" alt="" /></a></li>
            <li><a href="<?=site_url('/bandas/');?>"><img src="images/botonbandas.png" alt="" /></a></li>
            <li><a href="<?=site_url('/contacto/');?>"><img src="images/botoncontacto.png" alt="" /></a></li>
        </ul>
    </div>

    <div id="search"></div>

    <div id="banner-centro">
      <p>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="542" height="55">
                <param name="movie" value="images/flash/banner.swf" />
                <param name="quality" value="high" />
                <embed src="images/flash/banner.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="542" height="55"></embed>
            </object>
      </p>
    </div>
</div>