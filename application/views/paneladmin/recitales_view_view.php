        <h1>Detalle Recital</h1>

        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Banda</label></div>
            <span class="text-medium"><?=$info['banda'];?></span>
        </div>

        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Genero</label></div>
            <span class="text-medium"><?=$info['genero_name'];?></span>
        </div>

        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Nombre Lugar</label></div>
            <span class="text-medium"><?=$info['lugar_name'];?></span>
        </div>

        <div class="append-bottom-small">
            <div class="span-4"><label class="float-left label-form">Domicilio Lugar</label></div>
            <span class="text-medium"><?=$info['lugar_address'];?></span>
        </div>

        <div class="append-bottom-small">
            <div class="span-4"><label class="label-form">Fecha</label></div>
            <span class="text-medium"><?=$info['date'];?></span>
        </div>

        <fieldset class="fieldset-form prepend-top">
            <legend>Lugar de ventas de entradas</legend>
            <table id="tblLugaresVta" class="table-lugar prepend-top-small" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td class="cell-1">Lugar</td>
                        <td>Domicilio</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                if( $info['lugarvta'] ){
                    foreach( $info['lugarvta']->result_array() as $row2 ){?>
                        <tr>
                            <td class="cell-1"><?=$row2['lugar_name'];?></td>
                            <td><?=$row2['lugar_address'];?></td>
                        </tr>
                    <?php }
                }?>
                </tbody>
            </table>
        </fieldset>

        <div class="append-bottom-small">
            <div class="span-6"><label class="label-form">Precio de entradas anticipadas</label></div>
            <span class="text-medium"><?=$info['price'];?></span>
        </div>
        <div class="append-bottom-small">
            <div class="span-6"><label class="label-form">Precio de entradas en puertas</label></div>
            <span class="text-medium"><?=$info['price2'];?></span>
        </div>

        <div class="prepend-top text-center">
            <button type="button" class="button-medium" onclick="location.href='<?=site_url('/paneladmin/recitales/index/'.$this->uri->segment(5));?>';">Volver</button>
        </div>
        