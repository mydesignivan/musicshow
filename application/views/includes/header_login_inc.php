<?php if( $this->session->userdata('level')==0 ){ // Usuario comun?>
    <form id="formLogin" action="<?=site_url('/login/logout');?>" method="post" enctype="application/x-www-form-urlencoded">
        <div class="login">
            <span class="text-small"><b>Usuario:&nbsp;</b><?=$this->session->userdata('username');?></span>
            <?php if( !strpos($this->uri->uri_string(), 'paneluser') ){?>
            &nbsp;&nbsp;&nbsp;
            <a href="<?=site_url('/paneluser/micuenta/');?>" class="link1">(mi cuenta)</a>
            <?php }?>
            &nbsp;&nbsp;&nbsp;
            <button type="submit" class="button-small">Salir</button>
            &nbsp;&nbsp;&nbsp;
        </div>
    </form>

<?php }else{ // Usuario Administrador?>

    <form id="formLogin" action="<?=site_url('/login/logout');?>" method="post" enctype="application/x-www-form-urlencoded">
        <div class="login">
            <span class="text-small"><b>Administrador:&nbsp;</b><?=$this->session->userdata('username');?></span>
            <?php if( !strpos($this->uri->uri_string(), 'paneladmin') ){?>
            &nbsp;&nbsp;&nbsp;
            <a href="<?=site_url('/paneladmin/index/');?>" class="link1">(Volver al panel)</a>
            <?php }?>
            &nbsp;&nbsp;&nbsp;
            <button type="submit" class="button-small">Salir</button>
            &nbsp;&nbsp;&nbsp;
        </div>
    </form>
<?php }?>
