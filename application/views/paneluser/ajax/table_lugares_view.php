<div class="clear">
    <span class="float-left text-small prepend-top-small">Haga click sobre un lugar para seleccionar.</span>
    <button type="button" class="button-large float-right" onclick="Recitales.action.lugar_new()">Nuevo Lugar</button>
</div>

<div class="list-lugar">
    <table id="tblLugares" class="table-lugar" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td class="cell-1">Lugar</td>
                <td class="cell-2">Acci&oacute;n</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $n=0;
            foreach( $listLugares as $row ){
                $n++;
                $class = $n%2 ? '' : 'class="row-par"';
             ?>
                <tr <?=$class;?>>
                    <td class="cell-1"><a class="link-title"><?=$row['name'];?></a></td>
                    <td class="cell-2">
                        <img src="images/ajax-loader3.gif" alt="Guardando" title="Guardando" class="hide img-ajaxloader" />
                        <a href="javascript:void(0)" onclick="Recitales.action.lugar_del(<?=$row['lugar_id'];?>, this)" class="link1">Eliminar</a>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
</div>