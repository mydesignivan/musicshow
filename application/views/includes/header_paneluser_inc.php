    <div class="span-24 last header">
        <!-- ================  TOP MENU  ================ -->
        <div class="span-24 last top-header"> 
            <?php require('header_login_inc.php');?>
        </div>
        <!-- ================  END TOP MENU  ================ -->
    </div>
    <!-- ================  MENU  ================ -->
    <div class="clear span-13 append-11 last menu-container">
        <ul class="menu">
            <li><a href="<?=site_url('/index/')?>" class="mnu_inicio">Inicio</a></li>
            <li><a href="<?=site_url('/paneluser/micuenta/')?>" class="mnu_inicio">Mi Cuenta</a></li>
            <li><a href="<?=site_url('/paneluser/recitales/');?>" class="mnu_recitales">Recitales</a></li>
    <?php //if( $this->session->userdata('username')=="imattoni" || $this->session->userdata('username')=="juanadmin" ) {?>
            <li><a href="<?=site_url('/paneluser/bandas/');?>" class="mnu_recitales">Bandas</a></li>
    <?php //}?>
        </ul>
    </div>
    <!-- ================  END MENU  ================ -->

    <!-- ================  BANNER HORIZONTAL  ================ -->
    <?php require('banner_center_inc.php');?>
    <!-- ================  END BANNER HORIZONTAL  ================ -->
