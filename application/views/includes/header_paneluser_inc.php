<div id="header">
    <div id="top">
        <div class="topmenu-top"></div>

        <div align="left"></div>
        <div id="bannertop">
            <div align="left"><a href="<?=site_url('/registro/');?>"><img src="../images/bannertop.png" alt="Registrate Gratis!" /></a></div>
        </div>
        <div align="left"></div>

        <div class="login">
        <?php
            echo '<form id="formLogin" action="'.site_url('/login/logout').'" method="post" enctype="application/x-www-form-urlencoded">';
            echo 'Usuario: '.$this->session->userdata('email').' <a href="'.site_url('/micuenta/').'">(mi cuenta)</a> ';
            echo '<input type="submit" value="Salir" class="inputlogin" />';
            echo '</form>';
         ?>
        </div>

    </div>


    <div id="topmenu">
        <ul>
            <li><a href="<?=site_url('/micuenta/')?>">Mi Cuenta  |  </a></li>
            <li><a href="<?=site_url('/recitales/');?>">&nbsp;&nbsp;Recitales</a></li>
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