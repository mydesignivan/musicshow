        <h1>Recitales</h1>

        <div class="float-right">
            <button type="button" class="button-large" onclick="location.href='<?=site_url('/paneluser/recitales/form/');?>';">Nuevo</button>
            <?php if( $listRecitales->num_rows>0 ){?>
            <button type="button" class="button-large" onclick="Recitales.action.edit()">Modificar</button>
            <button type="button" class="button-large" onclick="Recitales.action.del()">Eliminar</button>
            <?php }?>
        </div>

        <?php if( $listRecitales->num_rows>0 ){?>
            <table id="tbl-list" class="table-list" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td class="cell-1">&nbsp;</td>
                        <td class="cell-2">Banda</td>
                        <td class="cell-3">Lugar</td>
                        <td>Fecha</td>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $n=0;
                    foreach( $listRecitales->result_array() as $row ){
                    $n++;
                    $class = $n%2 ? '' : 'class="row-par"';
                ?>
                    <tr <?=$class;?>>
                        <td class="cell-1"><input type="checkbox" value="<?=$row['recital_id'];?>" /></td>
                        <td class="cell-2"><a href="<?=site_url('/paneluser/recitales/form/'.$row['recital_id']);?>" class="link-title"><?=$row['banda'];?></a></td>
                        <td class="cell-3"><?=$row['lugar_name'];?></td>
                        <td><?=$row['date'];?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>

        <?php }else{?>

            <div class="notice">No hay recitales cargados</div>

        <?php }?>