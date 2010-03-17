        <h1>Recordar Contrase&ntilde;a</h1>

        <?php if( @$status=="ok" ){?>
            <form id="form3" action="<?=site_url('/login/account_access/');?>" method="post">
                <p>
                    Muy Bien! Su contrase&ntilde;a ha sido cambiada!<br />
                    Por favor asegurese de memorizarla o anotarla en un lugar seguro.
                </p>

                <input type="submit" value="Acceder a su cuenta" />
                <input type="hidden" name="p1" value="<?=$data['username'];?>" />
                <input type="hidden" name="p2" value="<?=$data['password'];?>" />
            </form>

        <?php }else{?>

            <form id="form2" action="<?=site_url('/recordarcontrasenia/send_newpass/'.$this->uri->segment(3)."/".$this->uri->segment(4));?>" method="post">

                <p>
                    Cambie su Contrase&ntilde;a<br />
                    Por favor, elija una contrase&ntilde;a para usar con su cuenta de MusicShows.com.ar
                </p>
                <p>
                    <label for="txtPass" class="label-form cell-6">Nueva Contrase&ntilde;a</label>
                    <input type="password" name="txtPass" id="txtPass" class="input-form validate" />
                </p>
                <p>
                    <label for="txtPass" class="label-form cell-6">Verifique Nueva Contrase&ntilde;a</label>
                    <input type="password" name="txtPass_confirm" id="txtPass_confirm" class="input-form validate" />
                </p>

                <br />
                <button type="button" onclick="RememberPass.send2()">Enviar</button>

                <input type="hidden" name="usr" value="<?=@$username;?>" />
                <input type="hidden" name="token" value="<?=@$token;?>" />
            </form>
        <?php }?>

        <script type="text/javascript">
        <!--
            RememberPass.initializer();
        -->
        </script>