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
            <li><a href="<?=site_url('/paneladmin/index/')?>" class="mnu_inicio">Inicio</a></li>
            <li><a href="<?=site_url('/paneladmin/destacados/')?>" class="mnu_inicio">Destacados</a></li>
            <li><a href="<?=site_url('/paneladmin/recitales/');?>" class="mnu_recitales">Recitales</a></li>
            <li><a href="<?=site_url('/paneladmin/usuarios/');?>" class="mnu_recitales">Usuarios</a></li>
        </ul>
    </div>
    <!-- ================  END MENU  ================ -->

    <!-- ================  BANNER HORIZONTAL  ================ -->
    <?php require('banner_center_inc.php');?>
    <!-- ================  END BANNER HORIZONTAL  ================ -->
