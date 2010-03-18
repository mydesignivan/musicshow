    <div class="span-24 last header">
        <!-- ================  TOP MENU  ================ -->
        <div class="span-24 last top-header"> 
            <form id="formLogin" action="<?=site_url('/login/logout');?>" method="post" enctype="application/x-www-form-urlencoded">
                <div class="float-left border">
                    <b>Usuario:&nbsp;</b><span><?=$this->session->userdata('username');?></span>
                    <a href="<?=site_url('/panel/micuenta/');?>">(mi cuenta)</a>
                    <button type="submit" class="button-small">Salir</button>
                </div>
            </form>
        </div>
        <!-- ================  END TOP MENU  ================ -->
    </div>
    <!-- ================  MENU  ================ -->
    <div class="clear span-13 append-11 last menu-container">
        <ul class="menu">
            <li><a href="<?=site_url('/panel/micuenta/')?>" class="mnu_inicio">Mi Cuenta</a></li>
            <li><a href="<?=site_url('/panel/recitales/');?>" class="mnu_recitales">Recitales</a></li>
        </ul>
    </div>
    <!-- ================  END MENU  ================ -->

    <!-- ================  BANNER HORIZONTAL  ================ -->
    <?php require('banner_center_inc.php');?>
    <!-- ================  END BANNER HORIZONTAL  ================ -->
