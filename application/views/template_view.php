<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Music Shows</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <?php require('includes/head_inc.php');?>
</head>

<body>
<div class="container showgrid">
    <!-- ================  HEADER  ================ -->
    <div class="span-24 last header">
        <!-- ================  TOP MENU  ================ -->
        <div class="span-24 last top-header"> 
            <form id="formLogin" action="<?//=site_url('/login/')?>" method="post" enctype="application/x-www-form-urlencoded">
                <div class="login">
                    <input type="text" name="txtLoginUser" class="input-login" value="Usuario" onfocus="clear_input(event)" onblur="set_input(event, 'Usuario')" />
                    <input type="text" name="txtLoginPass" class="input-login" value="Contrase&ntilde;a" onfocus="clear_input(event, 1)" onblur="set_input(event, 'Contrase&ntilde;a', 1)" />
                    <button type="submit" id="btnLogin" class="button-medium">Entrar</button>
                    <div id="message-login">El usuario y/o password son incorrectos</div>
                </div>
                <a href="<?//=site_url('/recordarcontrasenia/');?>" class="link3 float-right">¿Olvidaste tu Contrase&ntilde;a?</a>
                <a href="<?//=site_url('/registro/');?>" class="float-right"><img src="../images/bannertop.png" alt="Registrate Gratis!" /></a>
            </form>

            <!--<form id="formLogin" action="'.site_url('/login/logout').'" method="post" enctype="application/x-www-form-urlencoded">
                <span class="text-small"><b>Usuario:&nbsp;</b>juanfer<?//=$this->session->userdata('username');?></span>
                &nbsp;&nbsp;&nbsp;
                <a href="<?//=site_url('/panel/micuenta/');?>" class="link1">(mi cuenta)</a>
                &nbsp;&nbsp;&nbsp;
                <button type="submit" class="button-small">Salir</button>
                &nbsp;&nbsp;&nbsp;
            </form>-->
        </div>
        <!-- ================  END TOP MENU  ================ -->


        <!-- ================  MENU  ================ -->
        <div class="clear span-13 append-11 last menu-container">
            <ul class="menu">
                <li><a href="<?//=site_url('/index/')?>" class="mnu_inicio">Inicio</a></li>
                <li><a href="<?//=site_url('/fechas/');?>" class="mnu_fechas">Fechas</a></li>
                <li><a href="<?//=site_url('/bandas/');?>" class="mnu_bandas">Bandas</a></li>
                <li><a href="<?//=site_url('/contacto/');?>" class="mnu_contacto">Contacto</a></li>
            </ul>
        </div>
        <!-- ================  END MENU  ================ -->

        <!-- ================  BANNER HORIZONTAL  ================ -->
        <div class="clear span-24 last banner-horizontal">
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="542" height="55">
                <param name="movie" value="images/flash/banner.swf" />
                <param name="quality" value="high" />
                <embed src="images/flash/banner.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="542" height="55"></embed>
            </object>
        </div>
        <!-- ================  END BANNER HORIZONTAL  ================ -->
    </div>
    <!-- ================  END HEADER  ================ -->

    <!-- ================  MAIN CONTAINER  ================ -->
    <div class="clear span-24 main-container">
        <div class="span-16 column-left">
            <div class="anunciante">
                <div class="col-1"><img src="images/images.jpg" alt="" /></div>
                <div class="col-2">
                    <h2>12/12/12 Rock</h2>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula.</p>
                </div>
            </div>
            <div class="anunciante">
                <div class="col-1"><img src="images/images.jpg" alt="" /></div>
                <div class="col-2">
                    <h2>12/12/12 Rock</h2>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula.</p>
                </div>
            </div>
        </div>
        <div class="span-6 last column-right">
            <div class="sidebar">
                <img src="images/title_generos.png" alt="Generos" /><br />
                <ul class="list-generos">
                    <li><a href="#"><img src="images/item.png" alt="" class="item-img" /><span class="item">Rock Nacional</span></a></li>
                    <li><a href="#"><img src="images/item.png" alt="" class="item-img" /><span class="item">Rock Nacional</span></a></li>
                    <li><a href="#"><img src="images/item.png" alt="" class="item-img" /><span class="item">Rock Nacional</span></a></li>
                    <li><a href="#"><img src="images/item.png" alt="" class="item-img" /><span class="item">Rock Nacional</span></a></li>
                </ul>
                
                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="153" height="217" class="banner">
                  <param name="movie" value="images/flash/bannerlaterla.swf" />
                  <param name="quality" value="high" />
                  <embed src="images/flash/bannerlaterla.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="153" height="217"></embed>
                </object>

            </div>
        </div>
    </div>
    <!-- ================  END MAIN CONTAINER  ================ -->

    <!-- ================  FOOTER  ================ -->
    <div class="clear span-24 last footer">
        <p>Copyright &copy; 2010 - Todos los derechos reservados - <a href="#" class="link2">Terminos y Condiciones</a> - <a href="#" class="link2">Politicas de Privacidad</a></p>
    </div>
    <!-- ================  END FOOTER  ================ -->
</div>
</body>
</html>