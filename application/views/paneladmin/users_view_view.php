        <h1>Usuarios</h1>

        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Nombre Usuario</label></div>
            <span class="text-medium"><?=$info['username'];?></span>
        </div>
        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Nombre y Apellido</label></div>
            <span class="text-medium"><?=$info['name'];?></span>
        </div>
        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Email</label></div>
            <span class="text-medium"><?=$info['email'];?></span>
        </div>
        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Telefono</label></div>
            <span class="text-medium"><?=$info['phone'];?></span>
        </div>
        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Pa&iacute;s</label></div>
            <span class="text-medium"><?=$info['country'];?></span>
        </div>
        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Provincia</label></div>
            <span class="text-medium"><?=$info['state'];?></span>
        </div>
        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Ciudad</label></div>
            <span class="text-medium"><?=$info['city'];?></span>
        </div>
        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Domicilio</label></div>
            <span class="text-medium"><?=$info['address'];?></span>
        </div>
        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Newsletter</label></div>
            <span class="text-medium"><?=$info['newsletter']==1 ? "SI" : "NO";?></span>
        </div>

        <div class="prepend-top text-center">
            <button type="button" class="button-medium" onclick="location.href='<?=site_url('/paneladmin/usuarios/index/'.$this->uri->segment(5));?>';">Volver</button>
        </div>
        