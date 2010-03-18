        <form id="formLogin" action="<?=site_url('/login/logout');?>" method="post" enctype="application/x-www-form-urlencoded">
            <div class="login">
                <span class="text-small"><b>Usuario:&nbsp;</b><?=$this->session->userdata('username');?></span>
                &nbsp;&nbsp;&nbsp;
                <a href="<?=site_url('/panel/micuenta/');?>" class="link1">(mi cuenta)</a>
                &nbsp;&nbsp;&nbsp;
                <button type="submit" class="button-small">Salir</button>
                &nbsp;&nbsp;&nbsp;
            </div>
        </form>
