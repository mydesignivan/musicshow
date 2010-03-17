    <div class="span-24 last header">
        <!-- ================  TOP MENU  ================ -->
        <div class="span-24 last top-header"> 

    <?php if( !$this->session->userdata('logged_in') ){?>
            <form id="formLogin" action="<?=site_url('/login/')?>" method="post" enctype="application/x-www-form-urlencoded">
                <div class="login">
                    <input type="text" name="txtLoginUser" class="input-login" value="Usuario" onfocus="clear_input(event)" onblur="set_input(event, 'Usuario')" />
                    <input type="text" name="txtLoginPass" class="input-login" value="Contrase&ntilde;a" onfocus="clear_input(event, 1)" onblur="set_input(event, 'Contrase&ntilde;a', 1)" />
                    <button type="submit" id="btnLogin" class="button-medium float-left">Entrar</button>
                    <div id="message-login">El usuario y/o password son incorrectos</div>
                </div>
                <div class="container-links">
                    <a href="<?=site_url('/recordarcontrasenia/');?>" class="link-olvidocontra">¿Olvidaste tu Contrase&ntilde;a?</a>
                    <a href="<?=site_url('/registro/');?>"><img src="images/btn_registrarse.png" alt="Registrate Gratis!" /></a>
                </div>

                <?php if( $this->session->flashdata('statusLogin') ) {?>
                    <script type="text/javascript">
                    <!--
                        Login.show_error("<?=$this->session->flashdata('statusLogin');?>");
                    -->
                    </script>
                <?php }?>
            </form>
    <?php }else{?>
            <form id="formLogin" action="<?=site_url('/login/logout');?>" method="post" enctype="application/x-www-form-urlencoded">
                <span class="text-small"><b>Usuario:&nbsp;</b><?=$this->session->userdata('username');?></span>
                &nbsp;&nbsp;&nbsp;
                <a href="<?=site_url('/panel/micuenta/');?>" class="link1">(mi cuenta)</a>
                &nbsp;&nbsp;&nbsp;
                <button type="submit" class="button-small">Salir</button>
                &nbsp;&nbsp;&nbsp;
            </form>
    <?php }?>
        </div>
        <!-- ================  END TOP MENU  ================ -->
    </div>
    <!-- ================  MENU  ================ -->
    <div class="clear span-13 append-11 last menu-container">
        <ul class="menu">
            <li><a href="<?=site_url('/index/')?>" class="mnu_inicio">Inicio</a></li>
            <li><a href="<?=site_url('/fechas/');?>" class="mnu_fechas">Fechas</a></li>
            <li><a href="<?=site_url('/bandas/');?>" class="mnu_bandas">Bandas</a></li>
            <li><a href="<?=site_url('/contacto/');?>" class="mnu_contacto">Contacto</a></li>
        </ul>
    </div>
    <!-- ================  END MENU  ================ -->

    <!-- ================  BANNER HORIZONTAL  ================ -->
    <?php require('banner_center_inc.php');?>
    <!-- ================  END BANNER HORIZONTAL  ================ -->
