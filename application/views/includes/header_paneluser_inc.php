<div id="header">
    <div id="top">
        <div class="topmenu-top"></div>

        <div align="left">Hola, <?=$this->session->userdata('username');?></div>
        <div id="bannertop">
            
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

    <?php include('banner_center_inc.php');?>
</div>